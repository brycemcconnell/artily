<div class="post-title_wrapper">
	<a class="post-title" href="<?= $post["post_url"]; ?>"><?= $post["title"]; ?></a>
	<?php if (isset($_GET["action"]) == false && isset($_SESSION["user"]["id"]) &&
			 (($_SESSION["user"]["id"] == $post["user_id"]) || 
			  isset($_GET["action"]) == false && $_SESSION["user"]["level"] > 0)
			): ?>
		<button type="button" class="settings-btn btn"><?= $SVG->gear("#aaa"); ?></button>
	<?php endif; ?>
</div>
<div class="post-details">
	Posted by <a href="<?= $post["user_url"]; ?>"><?= $post["username"]; ?></a> <?= $post["elapsed"]; ?>
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
	if (!empty($post["post_contents"])):
	?>
	<div class="post-text">
		<?= $post["post_contents"]; ?>
	</div>
	<?php endif; ?>
</div>
