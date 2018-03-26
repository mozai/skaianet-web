// debug
console.log('Using HTML5/Chrome Audio API Engine.');


var radio_container = document.getElementById('radio-container');

// audio stuff
var audio = new Audio();
var audioSrc = '/radio.mp3';
audio.src = audioSrc;
audio.controls = false;
audio.autoplay = true;
audio.id = 'a';
audio.volume = 0.5;
radio_container.appendChild(audio);

function setVolume() {
    a.volume = $("#volume-control").val() / 100;
}

$("#playback-control").click(function() {
    if ($("#a")[0].paused) {
        $("#a")[0].src = "/radio.mp3";
        $("#a")[0].play();
        $("#playback-control")[0].innerHTML = '<span class="mdi-av-pause"></span>';
    } else {
        $("#a")[0].src = "about:blank";
        $("#a")[0].pause();
        $("#playback-control")[0].innerHTML = '<span class="mdi-av-play-arrow"></span>';
    }
});
