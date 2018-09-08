<?php include_once('../views/inc/head.php'); ?>
<?php include_once('../views/inc/header.php'); ?>


<script src="/assets/js/heartPost.js"></script>

<main class="main">
	<button id="list_view">List View</button>
	<button id="grid_view">Grid View</button>
	<div id="main" class="grid grid--list">
		<?php
		foreach ($posts as $key => $value) {
			// render_post($posts[$key]);
			include('../views/home/inc/board_post.php');
		}
		?>
	</div>
	<div class="grid-last">There seems to be nothing left...</div>

	<script>
		const listView = document.getElementById('list_view');
		const gridView = document.getElementById('grid_view');
		const main = document.getElementById('main');
		listView.onclick = function() {
			console.log(main);
			main.className = 'grid grid--list';
		}
		gridView.onclick = function() {
			main.className = 'grid';
		}
	</script>

</main>

<?php include_once('../views/inc/sidebar.php'); ?>
<?php include_once('../views/inc/footer.php'); ?>