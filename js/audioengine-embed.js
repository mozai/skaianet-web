// debug
console.log('Using Audio5js engine.');

function initAudio() {
    audio5js = new Audio5js({
        ready: function() {
            // this.load('http://stream.skaia.net/radio.mp3');
            this.load('//stream.skaia.net/radio.mp3');
            this.volume($("#volume-control").val() / 100);
            this.play();
        }
    });
}

//$.getScript('js/vendor/audio5.min.js', initAudio);
$.getScript('js/vendor/audio5.min.js');

function setVolume() {
    audio5js.volume($("#volume-control").val() / 100);
}


paused = true
$("#playback-control")[0].innerHTML = '<span class="mdi-av-play-arrow"></span>';

$("#playback-control").click(function() {
    if (paused) {
        initAudio();
        paused = false;
        $("#playback-control")[0].innerHTML = '<span class="mdi-av-pause"></span>';
    } else {
        audio5js.destroy();
        paused = true;
        $("#playback-control")[0].innerHTML = '<span class="mdi-av-play-arrow"></span>';
    }
});
