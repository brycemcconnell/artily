<?php

// function render_post($post) {
$post = $posts[$key];
// var_dump($post);
// die();
?>
<div class="item box bb <?= $post["class"]; ?>">

	<div id="h<?= $post["post_id"];?>" data-post-id="<?= $post["post_id"];?>" class="item-heart_container">
		<div class="item-heart <?= !empty($post["user_hearted"]) ? 'item-heart_active' : ''; ?>">
			<?= $SVG->heart(); ?>
		</div>
		<div class="item-heart_count">
			<?= $post["heart_count"] ?? 0; ?>
		</div>
	</div>
	<script>
		{
			const h = document.getElementById('h<?= $post["post_id"];?>');
			h.onclick = function() {
				const active = h.querySelector('.item-heart').classList.contains('item-heart_active') ? true : false;
				heartPost(h, active);
			} 
		}
	</script>

	<?php if (!empty($post["file_path"])): ?>
		<img src="<?= '/uploads/'.$post["file_path"]; ?>" alt="<?= $post["file_name"] ?? ""; ?>">
	<?php else: ?>
		<div class="item-text_post"><?= $post["content"] ?? ''; ?></div>
	<?php endif; ?>
	
	<div class="item-label">
		<div class="item-detail_container">
			<a href="<?= $post["post_url"]; ?>" class="item-title"><?= $post["title"] ?? ""; ?></a>
			<span class="item-date"><?= $post["elapsed"] ?? 0; ?></span>
		</div>
		<div class="item-detail_container">
			<span class="item-detail">Posted on <a href="/boards/<?= $post["board_name"]; ?>"><?= $post["board_name"]; ?></a> by <a href="<?= $post["user_url"]; ?>" data-user-id="<?= $post["user_id"]; ?>"><?= $post["username"] ?? ""; ?></a></span>
			<a href="<?= $post["post_url"]; ?>" class="item-comments">
				<?= $post["comment_count"] ?? 0; ?> Comments
			</a>
		</div>
		<div class="item-detail_container item-action_menu">
			View - Share - Report - Hide - Add to collection...
		</div>
	</div>

	<a class="item-link" href="<?= $post["post_url"]; ?>"></a>

</div>
<?php
// }
?>