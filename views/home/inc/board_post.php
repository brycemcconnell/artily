<?php
// function render_post($post) {
	$post = $posts[$key];
	?>
	<div class="item box bb <?= $post["class"]; ?>">
	<div id="h<?= $post["post_id"];?>" class="item-heart">
		<!-- ♥ -->
		<?= $SVG->heart(); ?>
	</div>
	<script>
		{
			const h = document.getElementById('h<?= $post["post_id"];?>');
			h.onclick = function() {
				console.log('h<?= $post["post_id"];?>');
				h.classList.toggle('item-heart_active');

				var data = {
					"post_id": "<?= $post["post_id"];?>"
				};
				fetch('http://artily.saber/api/posts/heart', {
					method: "POST",
					body: JSON.stringify(data),
					headers:{
						'Content-Type': 'application/json'
					}
				}).then(res => {
					console.log(res);
					return res.json();
				})
				  .then(response => console.log('Success:', response))
				  .catch(err => console.log(err)); 
			
			/* 	fetch('http://artily.saber/api/posts/heart', {
					method: "POST",
					body: JSON.stringify(data),
					headers:{
						'Content-Type': 'application/json'
					}
				}).then(res => {
					console.log(res);
					return res.json();
				})
				  .then(response => console.log('Success:', response))
				  .catch(err => console.log(err)); */
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
				<span class="item-detail">Posted on <a href="/boards/<?= $post["board_name"]; ?>"><?= $post["board_name"]; ?></a> by <a href="<?= $post["user_url"]; ?>"><?= $post["username"] ?? ""; ?></a></span>
				<a href="<?= $post["post_url"]; ?>" class="item-comments">
					<?= $post["comment_count"] ?? 0; ?> Comments
					<?= $post["heart_count"] ?? 0; ?> ♥
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