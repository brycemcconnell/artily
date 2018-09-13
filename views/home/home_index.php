<?php include_once('../views/inc/head.php'); ?>
<?php include_once('../views/inc/header.php'); ?>


<script src="/assets/js/heartPost.js"></script>

<main class="main">
	
	<div id="main" class="grid grid--list">
		<?php
		foreach ($posts as $key => $value) {
			include('../views/home/inc/board_post.php');
		}
		?>
	</div>
	<div class="grid-last">There seems to be nothing left...</div>

</main>
<?php include_once('../views/common/board_sort.php'); ?>
<?php include_once('../views/inc/sidebar.php'); ?>
<script>
	document.querySelectorAll(".js--hide-post").forEach(el => {
		el.onclick = function() {
			console.log(this);
			let parent = this.offsetParent;
			parent.classList.add("fade_out");
			setTimeout(() => {
				parent.style.display = "none";
			}, 1000);
			function moveUp(el) {
				el.classList.add('move_up');
				setTimeout(() => {
					el.classList.remove('move_up');
				}, 1000);
				if (el.nextElementSibling) {
					moveUp(el.nextElementSibling)
				}
			}
			moveUp(parent.nextElementSibling);
			
			
		}
	})
</script>
<?php include_once('../views/inc/footer.php'); ?>
