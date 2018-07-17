<?php

function render_post($post) {

	
	?>
	<div class="item box bb <?= $post["class"]; ?>">
		<?php if (isset($post["file_path"])): ?>
		<img src="<?= '/public/uploads/'.$post["file_path"]; ?>" alt="<?= $post["file_name"] ?? ""; ?>">
		<?php else: ?>
		<div class="item-text_post"><?= $post["post_contents"] ?? ''; ?></div>
		<?php endif; ?>
		
		<div class="item-label">
			<div class="item-detail_container">
				<a href="<?= $post["post_url"]; ?>" class="item-title"><?= $post["title"] ?? ""; ?></a>
				<span class="item-date"><?= $post["elapsed"] ?? 0; ?></span>
			</div>
			<div class="item-detail_container">
				<span class="item-detail">Posted on <a href="board/<?= $post["artboard_name"]; ?>"><?= $post["artboard_name"]; ?></a> by <a href="<?= $post["user_url"]; ?>"><?= $post["username"] ?? ""; ?></a></span>
				<a href="<?= $post["post_url"]; ?>" class="item-comments"><?= $post["comment_count"] ?? 0; ?> Comments</a>
			</div>
		</div>
		<a class="item-link" href="<?= $post["post_url"]; ?>"></a>
	</div>
<?php
}
?>