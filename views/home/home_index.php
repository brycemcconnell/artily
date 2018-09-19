<?php include_once('../views/inc/head.php'); ?>
<?php include_once('../views/inc/header.php'); ?>


<script src="/assets/js/heartPost.js"></script>

<main class="main">
<?php include_once('../views/common/board_sort.php'); ?>
	<div id="main" class="grid grid--list">
		<?php
		foreach ($posts as $key => $value) {
			include('../views/home/inc/board_post.php');
		}
		?>
	</div>
	<div class="grid-last">There seems to be nothing left...</div>

</main>

<?php include_once('../views/inc/sidebar.php'); ?>

<?php include_once('../views/inc/footer.php'); ?>
