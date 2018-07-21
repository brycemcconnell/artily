<?php
include_once('../views/inc/head.php');
?>

<?php include_once('../views/inc/header.php');?>
<main class="main">
	<div class="box bb reply-wrapper">
		<?php 
			// Show original post
			include_once("original_post.php");
		?>

		<form method="post" action="">
			<label for="confirmdelete">Are you sure you want to completely delete this post? This is irreversible.</label>
			<input type="checkbox" name="confirmdelete" id="confirmdelete">
			<input class="btn theme-btn" type="submit" name="submitdelete">
		</form>
	</div>
</main>
		<?php include_once('../views/inc/sidebar.php');?>
<?php include_once('../views/inc/footer.php');?>
