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
    $.getScript('js/audioengine-embed.js');
//}

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
    updateMetadata();
}, 10000);

var autoTimer = setInterval(function() {
    songPosition = songPosition + 0.3;
    if (songPosition >= 0) {
        updateProgress();
    }
}, 300);

updateMetadata();
