var songPosition = -1;
var upToDate = true;

function setAlert(type, content, dismissable) {
    $('.alert-section').css('visibility', 'visible');
    var d_class = ((dismissable) ? " alert-dismissible" : "");
    var d_button = ((dismissable) ? "<button type=\"button\" class=\"close\" data-dismiss=\"alert\" aria-label=\"Close\"><span aria-hidden=\"true\">&times;</span></button>" : "");
    
    if (type.localeCompare("info") == 0) {
    $('.alert-section')[0].innerHTML = "<div class=\"alert alert-info" + d_class + "\" id=\"alert\" role=\"alert\" style=\"color:grey;\">" + d_button + "<p>" + content + "</p></div>";
    } else if (type.localeCompare("warning") == 0) {
        $('.alert-section')[0].innerHTML = "<div class=\"alert alert-warning" + d_class + "\" id=\"alert\" role=\"alert\" style=\"color:white;\">" + d_button + "<p>" + content + "</p></div>";
    } else if (type.localeCompare("error") == 0) {
        $('.alert-section')[0].innerHTML = "<div class=\"alert alert-error" + d_class + "\" id=\"alert\" role=\"alert\" style=\"color:white;\">" + d_button + "<p>" + content + "</p></div>";
    } else if (type.localeCompare("success") == 0) {
        $('.alert-section')[0].innerHTML = "<div class=\"alert alert-material-success" + d_class + "\" id=\"alert\" role=\"alert\" style=\"color:white;\">" + d_button + "<p>" + content + "</p></div>";
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
        } 
        else
            removeAlert();
    });
}

function changeIframe(u) {
  $("#theIframe")[0].src = "";
  $("#theIframe")[0].src = u;
  return false;  // dont click through
}

function updateMetadata() {
    $.getJSON("/current.php", function(data) {
        $('#curSong')[0].innerHTML = data['title'];
        $('#curArtist')[0].innerHTML = data['artist'];
        $('#curAlbum')[0].innerHTML = data['album'];
        if (data['reqname'])
            $('#curRequestor')[0].innerHTML = data['reqname'];
        else
            $('#curRequestor')[0].innerHTML = "&lt;autoplay&gt;";
        $('#listeners')[0].innerHTML = data['listeners'];
        if(data['albumart'].startsWith('//'))
          $('#curAlbumArt')[0].src = data['albumart'];
        else 
          $('#curAlbumArt')[0].src = "//radio.skaia.net/img/artwork/" + data['albumart'];
        songLength = data['length'];
        songPosition = (data['time'] - Math.floor(Date.now() / 1000)) * -1;
        updateProgress();
    });
}

function updateProgress() {
    songPercent = (songPosition / songLength) * 100;
    if (songPercent >= 100) {
        if (upToDate == true) setTimeout(updateMetadata, 500);
        upToDate = false;
        songPercent = 100;
    } 
    else
        upToDate = true;
    $('.progress-bar').css('width', songPercent + '%').attr('aria-valuenow', songPercent);
}

var autoRefresh = setInterval(function() {
    updateAlert();
    updateMetadata();
}, 10000);

// fakes the timer but whatever
var autoTimer = setInterval(function() {
    songPosition = songPosition + 0.3;
    if (songPosition >= 0) { updateProgress(); }
}, 300);

updateAlert();
updateMetadata();
