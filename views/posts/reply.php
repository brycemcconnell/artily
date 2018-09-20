<?php
include_once('../views/inc/head.php');
?>

<?php include_once('../views/inc/header.php');?>
<main class="main">
	<div class="box bb reply-wrapper">
		Create a reply

		<?php 
			// Show original post
			$post = $op;
			include_once("inc/original_post.php")
		?>
		<?php 
			// If comment reply, show comment 
		if (isset($comment)): ?>
			<div>You are replying to <a href="<?= $comment["user_url"]; ?>"><?= $comment["username"]; ?></a>'s comment:</div>
		<div id="c<?= $comment["id"]; ?>" class="comment">
			<div class="comment-inner">
				<div class="comment-content">
					<?= nl2br($comment["content"]); ?>
				</div>
				<div class="comment-menu">
					<span class="comment-hidden_helper">Hidden</span>
					<span><?= $comment["elapsed"]; ?></span>
					<div class="comment-actions">
						<span class="cmt-dot">&#9679;</span>
						<a href="<?= strtok($_SERVER["REQUEST_URI"],'?'); ?>#c<?= $comment["id"]; ?>">Permalink</a>
						<a href="/report?type=comment&id=<?= $comment["id"]; ?>">Report</a>
					</div>
				</div>
			</div>
		</div>

		<?php endif; ?>


		<form class="reply-form" method="post" action="">
			<div>
				<textarea name="content"></textarea>
			</div>
			<div>
				<input type="submit" value="Preview" name="preview">
				<input type="submit" value="Post" name="replysubmit">
			</div>
		</form>
	</div>
</main>
<?php include_once('../views/inc/sidebar.php');?>
<?php include_once('../views/inc/footer.php');?>


