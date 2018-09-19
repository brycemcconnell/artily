
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

	if (boardSorter) {
    const listView = document.getElementById('list_view');
    const gridView = document.getElementById('grid_view');
    const main = document.getElementById('main');
    listView.onclick = function() {
      main.className = 'grid grid--list';
      listView.className = "board_sorter-btn board_sorter-btn--active";
      gridView.className = "board_sorter-btn";
    }
    gridView.onclick = function() {
      main.className = 'grid';
      listView.className = "board_sorter-btn";
      gridView.className = "board_sorter-btn board_sorter-btn--active";
    }

		const boardSelector = document.getElementById('boardSorterSelector');
		boardSelector.onchange = function() {
			this.form.submit();
		}
	}

	document.querySelectorAll(".js--hide-post").forEach(el => {
		el.onclick = function() {
			console.log(this);
			let parent = this.offsetParent;
			parent.classList.add("fade_out");
			setTimeout(() => {
				parent.style.display = "none";
			}, 1000);
		}
	})
</script>
</body>
</html>
