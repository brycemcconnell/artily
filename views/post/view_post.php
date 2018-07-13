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
				<img src="<?= '/public/uploads/'.$post["file_path"]; ?>">
				<div class="post-image_sizer">
					<div class="post-image_size_icon expand"><?= $SVG->expand('#fff'); ?></div>
					<div class="post-image_size_icon shrink"><?= $SVG->shrink('#fff'); ?></div>
				</div>
			</div>
			<?php
			endif;
			if (!empty($post["content"])):
			?>
			<div>
				<?= $post["content"]; ?>
			</div>
			<?php endif; ?>
		</div>
		Reply Count (10)
		<form>
			<label>Quick Reply</label>
		<textarea></textarea>
		</form>
		<!-- <pre><?php var_dump($comments); ?></pre>  -->
		<?php 
		$depth = 0;
		function this_func($elements) {
			global $depth;
			foreach ($elements as $element):
				$comment_class = $depth == 0 ? "comment comment-no_border" : "comment";
				?>
				<div class="<?= $comment_class; ?>">
					<div class="comment-inner">
						<button class="comment-collapse" onclick="collapseChildren(this);">[<span class="cc-close">&#65291;</span><span class="cc-open">&#65293;</span>]</button>
						<div class="comment-content">
							<!-- <?= $element["id"]; ?> -->
							<!-- <?= $element["post_id"]; ?> -->
							
							<!-- <?= $element["user_id"]; ?> -->
							<!-- <?= $element["parent_comment_id"]; ?> -->
							
							<?= $element["content"]; ?>
							<!-- <?= (int)$depth; ?> -->
						</div>
						<div class="comment-menu">
							<span class="comment-hidden_helper">Hidden</span>
							<span><?= $element["elapsed"]; ?> by <a href="user?id=<?= $element["user_id"]; ?>"><?= $element["username"]; ?></a></span>
							&#9679;
							(<?= count($element["children"]); ?>) Replies
							<div class="comment-actions">
								&#9679;
								<a href="comment?id=<?= $element["id"]; ?>&action=report">Report</a>
								<a href="comment?id=<?= $element["id"]; ?>&action=reply">Reply &#8617;</a>
							</div>
						</div>
					</div>
				<?php
				if (isset($element["children"])) {
					$depth = 1;
					this_func($element["children"]);
				}
				?></div><?php
				$depth = 0;
			endforeach; 
		} 
		this_func($comments);
		?>
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
	
		
	
</main>
<?php include_once('../views/inc/sidebar.php');?>
<?php include_once('../views/inc/footer.php');?>


