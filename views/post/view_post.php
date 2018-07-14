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
<main class="main main-flex">
	<div class="view_post">
		<div>
			<a class="post-title" href="post?id=<?= $post["post_id"]; ?>"><?= $post["title"]; ?></a>
		</div>
		<div class="post-details">
			Posted by <a href="user?id=<?= $post["user_id"]; ?>"><?= $post["username"]; ?></a> <?= $post["elapsed"]; ?>
		</div>
		<div class="post-content">
			<?php
			if (isset($post["file_path"])): 
			?>
			<div class="post-image" onclick="toggleImageSize(this);">
				<img src="<?= '/public/uploads/'.$post["file_path"]; ?>" alt="<?= $post["file_name"].'.'.$post["file_type"] ?>">
				<div class="post-image_sizer">
					<div class="post-image_size_icon expand"><?= $SVG->expand('#fff'); ?></div>
					<div class="post-image_size_icon shrink"><?= $SVG->shrink('#fff'); ?></div>
				</div>
			</div>
			<?php
			endif;
			if (!empty($post["content"])):
			?>
			<div class="post-text">
				<?= $post["content"]; ?>
			</div>
			<?php endif; ?>
		</div>
		
		<form action="post?id=<?= $post["post_id"]; ?>&action=reply" method="post" class="cmt-qr">
			<div class="cmt-qr_title">
				Quick Reply - 
				<?php if (isset($_SESSION["user"])): ?>
				Logged in as <?= $_SESSION["user"]["username"]; ?>
				<?php else: ?>
					<a href="/account?action=login">Login</a> or <a href="/account?action=signup">signup</a> to comment
				<?php endif; ?>
			</div>
			<textarea class="cmt-qr_text" name="content"></textarea>
			<button type="submit" name="replysubmit">Reply</button>
		</form>
		<div class="cmt-srt_menu">
			Reply Count (<?= $response["count"] ?? 0; ?>)
			Sort by: new
		</div>
		<?php 
		
		function this_func($elements, $depth = 0) {
			foreach ($elements as $element):
				if ($element["parent_comment_id"] == NULL)
					$depth = 0;
				$comment_class = $depth == 0 ? "comment comment-top" : "comment";
				?>
				<div class="<?= $comment_class; ?>">
					<div class="cmt-vline"></div>
					<div class="comment-inner">
						<button class="comment-collapse" onclick="collapseChildren(this);">[<span class="cmt-close">&#65291;</span><span class="cmt-open">&#65293;</span>]</button>
						<div class="comment-content">
							<!-- {<?= $element["id"]; ?>} -->
							<!-- <?= $element["post_id"]; ?> -->
							
							<!-- <?= $element["user_id"]; ?> -->
							<!-- <?= $element["parent_comment_id"]; ?> -->
							
							<?= nl2br($element["content"]); ?>
							<!-- <?= (int)$depth; ?> -->
						</div>
						<div class="comment-menu">
							<span class="comment-hidden_helper">Hidden</span>
							<span><?= $element["elapsed"]; ?> by <a href="user?id=<?= $element["user_id"]; ?>"><?= $element["username"]; ?></a></span>
							<span class="cmt-dot">&#9679;</span>
							(<?= count($element["children"]); ?>) Replies
							<div class="comment-actions">
								<span class="cmt-dot">&#9679;</span>
								<a href="comment?id=<?= $element["id"]; ?>">Permalink</a>
								<a href="comment?id=<?= $element["id"]; ?>&action=report">Report</a>
								<a href="comment?id=<?= $element["id"]; ?>&action=reply">Reply &#8617;</a>
							</div>
						</div>
					</div>
				<?php
				if (count($element["children"])) {
					$depth += 1;
					this_func($element["children"], $depth);
				}
				?></div><?php
			endforeach; 
		} 
		this_func($comments);
		?>
	</div>
	<?php include_once('../views/inc/artbar.php'); ?>
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
	
		
	
</main>
<?php include_once('../views/inc/sidebar.php');?>
<?php include_once('../views/inc/footer.php');?>


