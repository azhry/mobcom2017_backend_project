<audio controls id="audio">
	<source id="audio-source" src="#" type="audio/mpeg">
	Your browser does not support the audio element.
</audio>
<script type="text/javascript">
	$(document).ready(function() {
		var currently_playing = false;
		var audio = document.getElementById('audio');
		
		setInterval(function() {
			var is_ended = audio.ended;
			if (audio.ended) {
				$.ajax({
					url: '<?= base_url('player/refresh') ?>',
					type: 'POST',
					data: {
						currently_playing: currently_playing,
						is_ended: is_ended
					},
					success: function(response) {
						var json = $.parseJSON(response);
						currently_playing = json.currently_playing;
						if (json.request_available) {
							audio.src = '<?= base_url() ?>assets/musics/' + json.src;
							audio.play();
						}
					},
					error: function(e) {
						console.log(e.responseText);
					}
				});
			} else {
				$.ajax({
					url: '<?= base_url('player/refresh') ?>',
					type: 'POST',
					data: {
						currently_playing: currently_playing,
						is_ended: is_ended
					},
					success: function(response) {
						var json = $.parseJSON(response);
						if (json.request_available == true && !currently_playing) {
							audio.src = '<?= base_url() ?>assets/musics/' + json.src;
							console.log('URL: ' + audio.src);
							audio.play();
							currently_playing = json.currently_playing;
						}
					},
					error: function(e) {
						console.log(e.responseText);
					}
				});
			}
		}, 3000);
	});
</script>