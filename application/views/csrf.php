<?= form_open('login') ?>
	<input type="submit" value="submit">
<?= form_close() ?>

<form action="<?= base_url('login') ?>" method="POST">
	<input type="submit" value="coba">
</form>

<form id="crack" action="<?= base_url('login') ?>" method="POST">
	<input type="hidden" id="csrf_placeholder">
</form>
<button id="crack_btn" onclick="crack();">crack</button>

<script type="text/javascript">
	var form = document.getElementById('crack');
	function crack() {
		var input = document.getElementsByName('csrf_test_name');
		document.getElementById('csrf_placeholder').setAttribute('name', 'csrf_test_name');
		document.getElementById('csrf_placeholder').setAttribute('value', input[0].value);
		form.submit();
	}
</script>