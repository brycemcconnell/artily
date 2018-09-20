<?php
include_once('../views/inc/head.php');
?>

<?php
	if (isset($_POST["submitPost"])) {
		print_r($_POST["submitPost"]);
		echo "Post recieved successfully";
	}
?>

<?php include_once('../views/inc/header.php');?>
<main class="main">
	<!-- <div class="banner">I am a banners</div> -->
	<section class="board">
		<div class="view_post-wrapper">
			<div class="view_post box bb">
			
					<?php include_once("inc/original_post.php"); ?>
				
				<form action="<?= $_SERVER["REQUEST_URI"];?>/reply" method="post" class="cmt-qr">
					<input type="hidden" name="redirect" value="<?= $_SERVER["REQUEST_URI"];?>"/>
					<div class="cmt-qr_title">
						Quick Reply - 
						<?php if (isset($_SESSION["user"])): ?>
						Logged in as <?= $_SESSION["user"]["username"]; ?>
						<?php else: ?>
							<a href="/account?action=login">Login</a> or <a href="/account?action=signup">signup</a> to comment
						<?php endif; ?>
					</div>
					<textarea class="cmt-qr_text" name="content"></textarea>
					<button class="btn theme-btn post-btn" type="submit" name="quickreplysubmit">Reply</button>
				</form>
				<div class="cmt-srt_menu">
					Reply Count (<?= $response["count"] ?? 0; ?>)
					Sort by: new
				</div>
				<?php include_once('../views/inc/post_comments.php'); ?>
			</div>
			<script>
				function collapseChildren(item) {
					if (item.offsetParent) {
						item.offsetParent.classList.toggle('hide-comment')
					}
				}
				function toggleImageSize(item) {
					item.classList.toggle('post-image_active')
				}
			</script>
			
				
		</div>
		<?php include_once('../views/inc/board_sidebar.php'); ?>
	</section>
</main>
<?php include_once('../views/inc/sidebar.php');?>
<?php include_once('../views/inc/footer.php');?>


