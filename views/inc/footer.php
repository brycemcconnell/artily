
<footer class="footer">
	<div class="footer-container container">
		Footer - File Path:<?= __DIR__  ?>
		<button type="button" onclick="toggleDebug()">Debug</button>
	</div>
</footer>
<div class="debug box bb none">
	<?php 
		use App\Core\Request as Request;
		Request::print_debug("default");
	?>
</div>
<script>
	function toggleDebug() {
		document.querySelector('.debug').classList.toggle('none');
	}
	
	// Close floating menus when clicking outside them
	window.addEventListener('mouseup', (e) => {
		let divs = [...document.querySelectorAll('.floating-menu:not(.none-withjs)')];
		// console.log(e)
		divs.forEach(div => {
			let coords = div.getBoundingClientRect();
			if ((e.clientX > coords.left && e.clientX < coords.right &&
				 e.clientY < coords.bottom && e.clientY > coords.top) == false) {
				div.classList.add('none-withjs');
				// console.log('hit', coords, e.clientX, e.clientY);
			}
		});
	});

</script>
</body>
</html>
