<audio controls id="audio">
	<source src="musics/Scenarioart.mp3" type="audio/mpeg">
	Your browser does not support the audio element.
</audio>

<script type="text/javascript">
	var audio = document.getElementById('audio');
	audio.autoplay = true;
	audio.load();
	setInterval(function() {
		if (audio.ended) {
			audio.load();
		}
	}, 1000);
</script>