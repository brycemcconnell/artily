<!-- <pre> -->
<?php
$board = $board_data["name"];
// var_dump($data);
$posts = $board_posts;
?>
<!-- </pre><br> -->
<!-- Wow i'm a board -->

<?php include_once('../views/inc/head.php'); ?>
<?php include_once('../views/inc/header.php'); ?>


<script src="/assets/js/heartPost.js"></script>

<main class="main">

	<div id="main" class="grid grid--list">
		<?php
		foreach ($posts as $key => $value) {
			// render_post($posts[$key]);
			include('../views/home/inc/board_post.php');
		}
		?>
	</div>
	<div class="grid-last">There seems to be nothing left...</div>
 
</main>
<?php include_once('../views/common/board_sort.php'); ?>
<?php include_once('../views/inc/sidebar.php'); ?>
<?php include_once('../views/inc/footer.php'); ?>