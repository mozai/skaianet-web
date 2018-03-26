// debug
console.log('Using HTML5/Chrome Audio API Engine.');

// Paul Irish requestAnimationFrame Polyfill
// http://www.paulirish.com/2011/requestanimationframe-for-smart-animating/
window.requestAnimFrame = (function() {
    return window.requestAnimationFrame ||
        window.webkitRequestAnimationFrame ||
        window.mozRequestAnimationFrame ||
        function(callback) {
            window.setTimeout(callback, 1000 / 60);
        };
})();

var radio_container = document.getElementById('radio-container');
// canvas stuff
var canvas = document.getElementById('spectrum');
canvas_context = canvas.getContext('2d');

// audio stuff
var audio = new Audio();
//var audioSrc = 'http://stream.skaia.net:8000/radio.mp3';
var audioSrc = 'http://stream.skaia.net:8000/radio.mp3';
audio.src = audioSrc;
audio.controls = false;
audio.autoplay = true;
audio.crossOrigin = 'anonymous';
audio.id = 'a';
audio.volume = 0.5;
radio_container.appendChild(audio);

// analyser stuff
var context = new AudioContext();
var analyser = context.createAnalyser();
analyser.fftSize = 2048;

// connect the stuff up to eachother
var source = context.createMediaElementSource(audio);
source.connect(analyser);
analyser.connect(context.destination);
freqAnalyser();


// draw the analyser to the canvas
function freqAnalyser() {
    window.requestAnimFrame(freqAnalyser);
    var sum;
    var average;
    var bar_width;
    var scaled_average;
    var num_bars = 256;
    var data = new Uint8Array(2048);
    analyser.getByteFrequencyData(data);

    // clear canvas
    canvas_context.clearRect(0, 0, canvas.width, canvas.height);
    canvas.width = window.innerWidth - 100;
    var bin_size = Math.floor(data.length / num_bars);
    for (var i = 0; i < num_bars; i += 1) {
        sum = 0;
        for (var j = 0; j < bin_size; j += 1) {
            sum += data[(i * bin_size) + j];
        }
        average = sum / bin_size;
        bar_width = (canvas.width / num_bars) * 2.7;
        scaled_average = (average / 256) * canvas.height;
        canvas_context.fillStyle = "rgba(0,0,0,0.1)";
        canvas_context.fillRect(i * bar_width, canvas.height, bar_width - 2, -scaled_average);
    }
}

function setVolume() {
    a.volume = $("#volume-control").val() / 100;
}

$("#playback-control").click(function() {
    if ($("#a")[0].paused) {
        // $("#a")[0].src = "http://stream.skaia.net:8000/radio.mp3";
        $("#a")[0].src = audioSrc;
        $("#a")[0].play();
        $("#playback-control")[0].innerHTML = '<span class="mdi-av-pause"></span>';
    } else {
        $("#a")[0].src = "about:blank";
        $("#a")[0].pause();
        $("#playback-control")[0].innerHTML = '<span class="mdi-av-play-arrow"></span>';
    }
});
