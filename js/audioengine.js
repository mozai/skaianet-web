
var paused = true
var chrome_warning = "Modern web browsers do not auto-playing music.\nPlease click on the album art to start playing."

function initAudio() {
	audio5js = new Audio5js({
		throw_errors: true,
		ready: function(player) {
			this.on('error', function(err){console.log(err.message);}, this)
			this.load('//stream.skaia.net/radio.mp3')
			this.volume($("#volume-control").val() / 100)
			console.log("this.play()")
			this.play()
		}
	})
}

console.log('Using Audio5js engine.')
alert(chrome_warning)
//$.getScript('js/vendor/audio5.min.js', initAudio)
$.getScript('js/vendor/audio5.min.js')

function setVolume() {
	audio5js.volume($("#volume-control").val() / 100)
}

// we have to start "paused" because of modern browsers
$('.playback-control-section div').css('visibility', 'visible');
$("#playback-control")[0].innerHTML = '<span class="mdi-av-play-arrow"></span>'

$("#playback-control").click(function() {
	if (paused) {
		initAudio()
		paused = false
		$("#playback-control")[0].innerHTML = '<span class="mdi-av-pause"></span>'
        $('.playback-control-section div').css('visibility', '');
	} else {
		audio5js.destroy()
		paused = true
        $('.playback-control-section div').css('visibility', 'visible');
		$("#playback-control")[0].innerHTML = '<span class="mdi-av-play-arrow"></span>'
	}
})
