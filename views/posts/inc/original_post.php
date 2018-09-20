<div class="post-title_wrapper">

		<div id="h<?= $post["post_id"];?>" data-post-id="<?= $post["post_id"];?>" class="view_post-heart_container">
			<div class="js--heart view_post-heart <?= !empty($post["user_hearted"]) ? 'js--heart_active' : ''; ?>">
				<?= $SVG->heart(); ?>
			</div>
			<div class="js--heart_count view_post-heart_count">
				<?= $post["heart_count"] ?? 0; ?>
			</div>
		</div>
		<script>
			{
				const h = document.getElementById('h<?= $post["post_id"];?>');
				h.onclick = function() {
					const active = h.querySelector('.view_post-heart').classList.contains('js--heart_active') ? true : false;
					heartPost(h, active);
				} 
			}
		</script>
		<script src="/assets/js/heartPost.js"></script>
			
		<div class="view_post-title_information">
			<a class="post-title" href="<?= $post["post_url"]; ?>"><?= $post["title"]; ?></a>
			<div class="post-details">
				Posted by <a href="<?= $post["user_url"]; ?>"><?= $post["username"]; ?></a> <span class="time-tooltip" title="<?= $post["created"]; ?>"><?= $post["elapsed"]; ?></span>
			</div>
		</div>

		<?php if (isset($_GET["action"]) == false && isset($_SESSION["user"]["id"]) &&
				(($_SESSION["user"]["id"] == $post["user_id"]) || 
					isset($_GET["action"]) == false && $_SESSION["user"]["level"] > 0)
				): ?>
			<button type="button" class="settings-btn btn" onclick="togglePostMenu();"><?= $SVG->gear("#aaa"); ?></button>
			<ul class="post-options bb box none-withjs floating-menu">
				<li><a href="./edit"><span class="svg-icon"><?= $SVG->edit();?></span>Edit</a></li>
				<li><a href="./delete"><span class="svg-icon"><?= $SVG->garbage();?></span>Delete</a></li>
			</ul>
			<script>
			function togglePostMenu() {
				document.querySelector('.post-options').classList.toggle('none-withjs');
			}
			</script>
		<?php endif; ?>
</div>
	
	<div class="post-content">
		<?php	if (!empty($post["file_path"])): ?>
		<div class="post-image" onclick="toggleImageSize(this);">
			<img src="<?= '/uploads/'.$post["file_path"]; ?>" alt="<?= $post["file_name"].'.'.$post["file_type"] ?>">
			<div class="post-image_sizer">
				<div class="post-image_size_icon expand"><?= $SVG->expand('#fff'); ?></div>
				<div class="post-image_size_icon shrink"><?= $SVG->shrink('#fff'); ?></div>
			</div>
		</div>
		<?php endif; ?>
		<?php if (!empty($post["content"])):?>
			<div class="post-text">
				<?= nl2br($post["content"]); ?>
			</div>
		<?php endif; ?>
</div>
