<?php
function render_post($post) {
	?>
	<div class="item <?= $post["class"]; ?>">
		<?php if (isset($post["file_path"])): ?>
		<img src="<?= '/public/uploads/'.$post["file_path"]; ?>" alt="<?= $post["file_name"] ?? ""; ?>">
		<?php else: ?>
		<div class="item-text_post"><?= $post["post_contents"] ?? ''; ?></div>
		<?php endif; ?>
		
		<div class="item-label">
			<div class="item-detail_container">
				<a href="post?id=<?= $post["post_id"]; ?>" class="item-title"><?= $post["title"] ?? ""; ?></a>
				<span class="item-date"><?= $post["elapsed"] ?? 0; ?></span>
			</div>
			<div class="item-detail_container">
				<span>Posted on <a href="artboard?id=<?= $post["artboard_id"]; ?>"><?= $post["artboard_name"]; ?></a> by <a href="user?id=<?= $post["user_id"]; ?>"><?= $post["username"] ?? ""; ?></a></span>
				<a href="post?id=<?= $post["post_id"]; ?>" class="item-comments"><?= $post["comment_count"] ?? 0; ?> Comments</a>
			</div>
		</div>
		<a class="item-link" href="post?id=<?= $post["post_id"]; ?>"></a>
	</div>
<?php
}
?>