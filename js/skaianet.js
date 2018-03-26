$(function() {
    $.material.init();
    $('[data-toggle="tooltip"]').tooltip();
    $("#volume-control").noUiSlider({
        start: 50,
        connect: "lower",
        step: 1,
        range: {min: 0, max: 100}
    }); 
});

songPosition = -1;
upToDate = true;

//if (/chrome/i.test(navigator.userAgent)) {
//    $.getScript('js/spectrum.js');
//} else {
    $.getScript('js/audioengine.js');
//}

function setAlert(type, content, dismissable) {
    $('.alert-section').css('visibility', 'visible');
    var d_class = ((dismissable) ? " alert-dismissible" : "");
    var d_button = ((dismissable) ? "<button type=\"button\" class=\"close\" data-dismiss=\"alert\" aria-label=\"Close\"><span aria-hidden=\"true\">&times;</span></button>" : "");
    
    if (type.localeCompare("info") == 0) {
    $('.alert-section')[0].innerHTML = "<div class=\"alert alert-material-blue" + d_class + "\" id=\"alert\" role=\"alert\" style=\"color:white;\">" + d_button + "<p>" + content + "</p></div>";
    } else if (type.localeCompare("warning") == 0) {
        $('.alert-section')[0].innerHTML = "<div class=\"alert alert-material-orange" + d_class + "\" id=\"alert\" role=\"alert\" style=\"color:white;\">" + d_button + "<p>" + content + "</p></div>";
    } else if (type.localeCompare("error") == 0) {
        $('.alert-section')[0].innerHTML = "<div class=\"alert alert-material-red" + d_class + "\" id=\"alert\" role=\"alert\" style=\"color:white;\">" + d_button + "<p>" + content + "</p></div>";
    } else if (type.localeCompare("success") == 0) {
        $('.alert-section')[0].innerHTML = "<div class=\"alert alert-material-green" + d_class + "\" id=\"alert\" role=\"alert\" style=\"color:white;\">" + d_button + "<p>" + content + "</p></div>";
    }
}

function removeAlert() {
    $('.alert-section').css('visibility', 'hidden');
    $('.alert-section')[0].innerHTML = "";
}

function updateAlert() {
    $.getJSON("/current.php", function(data) {
        if (data['notifytext'] && data['notifytype'] > 0) {
            if (data['notifytype'] == 1)
                setAlert("info", data['notifytext'], false);
            else if (data['notifytype'] == 2)
                setAlert("success", data['notifytext'], false);
            else if (data['notifytype'] == 3)
                setAlert("warning", data['notifytext'], false);
            else if (data['notifytype'] == 4)
                setAlert("error", data['notifytext'], false);
        } else {
            removeAlert();
        }
    });
}

function updateMetadata() {
    $.getJSON("/current.php", function(data) {
        if (data['reqname']) {
            $('#curSong')[0].innerHTML = "<span class=\"label label-material-green\" data-toggle=\"tooltip\" data-placement=\"top\" title=\"\" data-original-title=\"Requested by: " + data['reqname'] + "\">Request</span> " + data['title'];
            $('[data-toggle="tooltip"]').tooltip();
        } else {
            $('#curSong')[0].innerHTML = data['title'];
        }
        $('#curArtist')[0].innerHTML = data['artist'];
        $('#curAlbum')[0].innerHTML = data['album'];
        $('#listeners')[0].innerHTML = data['listeners'];
        if(data['website']) {
            $('#website')[0].href = data['website'];
            $('#website')[0].target = '_blank';
            $('#website').show();
        }
        else {
            $('#website').hide();
            $('#website')[0].href = '#';
            $('#website')[0].target = '';
        }
        songLength = data['length'];
        songPosition = (data['time'] - Math.floor(Date.now() / 1000)) * -1;
        if ($('#album-art')[0].src != data['albumart']) {
            $('#album-art')[0].src = data['albumart'];
        }
        updateProgress();
    });
}

function updateProgress() {
    songPercent = (songPosition / songLength) * 100;
    if (songPercent >= 100) {
        if (upToDate == true) {
            setTimeout(updateMetadata, 500);
        }
        upToDate = false;
        songPercent = 100;
    } else {
        upToDate = true;
    }
    $('.progress-bar').css('width', songPercent + '%').attr('aria-valuenow', songPercent);
}

var autoRefresh = setInterval(function() {
    updateAlert();
    updateMetadata();
}, 10000);

var autoTimer = setInterval(function() {
    songPosition = songPosition + 0.3;
    if (songPosition >= 0) {
        updateProgress();
    }
}, 300);

updateAlert();
updateMetadata();
