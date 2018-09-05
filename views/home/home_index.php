<?php include_once('../views/inc/head.php'); ?>
<?php include_once('../views/inc/header.php'); ?>
<?php include_once('../views/home/inc/board_post.php'); ?>

<main class="main">
	<div class="grid">
		<?php
		foreach ($posts as $key => $value) {
			render_post($posts[$key]);
		}
		?>
	</div>
	<div class="grid-last">There seems to be nothing left...</div>
</main>

<?php include_once('../views/inc/sidebar.php'); ?>
<?php include_once('../views/inc/footer.php'); ?>