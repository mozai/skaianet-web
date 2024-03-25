$(function() {
    $.material.init();
    var $haystack = $('#songlist tbody tr');
    $(function() {
        $("[id^=search-text]").keyup(function() {
            var needle = $.trim($(this).val()).replace(/ +/g, ' ').toLowerCase();
            var $haystack = $('#songlist tbody tr');
            $haystack.show().filter(function() {
                var hay = $(this).text().replace(/\s+/g, ' ').toLowerCase();
                return !~hay.indexOf(needle); 
            }).hide();
        });
    });
    $(function() {
        $("[id^=request-button]").click(function() {
            // $(this).removeClass("btn-material-red").addClass("btn-material-green");
            var song_id = $(this).val();
            var req_name = $("#request-name").val();
            if (!req_name)
                req_name = "Anonymous";
            data = {'song': song_id, 'name': req_name};
            $.post("/api/request.php", data, function(response) {
                console.log(JSON.stringify(data));
                alert(response['message']);
                if(response['success'] == 1)
                    disableButton(song_id);
            });
        });
    });
});

function disableButton(songid) {
    $('#request-button-' + songid).prop('disabled', true).removeClass("btn-material-red").addClass("btn-material-grey").html("&nbsp;");
}

function updateRequestStatus() {
    $.getJSON("/api/request.php", function(data) {
        $('#queue_status').html('Requests Queue: ' + data['req_count'] + '<br>Your Requests: ' + data['your_req_count'])
        $('.request-button').prop('disabled', false).removeClass("btn-material-grey").addClass("btn-material-red").html('REQUEST');
        if (data['on_cooldown'] == 'all' || data['your_req_count'] >= 2 || data['req_count'] >= 10) {
            // on_cooldown is special 'all' value, or too many requests already queued
            $('.request-button').prop('disabled', true).html('&nbsp;');
        }
        else {
            // for (let i of songidlist) //  can't use because of Internet Explorer
            for(let i = data['on_cooldown'].length; i; i--)
                disableButton(data['on_cooldown'][i-1]);
        }
    });
}

var autoRefresh = setInterval(function() { updateRequestStatus(); }, 5000);

updateRequestStatus();
