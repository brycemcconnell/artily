
<footer class="footer">
	<div class="footer-container container">
		Footer - File Path:<?= __DIR__  ?>
		<button type="button" onclick="toggleDebug()">Debug</button>
	</div>
</footer>
<div class="debug box bb none">
	<?php 
		use App\Utils\MYREQ as MYREQ;
		MYREQ::print_debug("default");
	?>
</div>
<script>
	function toggleDebug() {
		document.querySelector('.debug').classList.toggle('none');
	}
	

</script>
</body>
</html>
