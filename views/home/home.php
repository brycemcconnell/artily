<?php include_once('../views/inc/head.php'); ?>
<?php include_once('../views/inc/header.php'); ?>
<?php include_once('../views/inc/board_post.php'); ?>

<main class="main">
	<div class="grid">
		<?php
		foreach ($posts as $key => $value) {
			render_post($posts[$key]);
		}
		?>

<!-- 		<div class="item">
			<a href="/">
				<img src="/public/photos/cat1.jpg">
			</a>
			<div class="item-label">
				<div class="item-detail_container">
					<a href="/" class="item-title">It's my cat</a>
					<a href="/">23 Comments</a>
				</div>
				<div class="">Posted on <a href="/">cats</a> by <a href="/">l33t_pie</a></div>
			</div>
		</div>
		<div class="item item-v2 item-h2">
			<a href="/">
				<img src="/public/photos/cat2.jpg">
			</a>
			<div class="item-label">
				<div class="item-detail_container">
					<a href="/" class="item-title">It's my cat</a>
					<a href="/">23 Comments</a>
				</div>
				<div class="">Posted on <a href="/">cats</a> by <a href="/">l33t_pie</a></div>
			</div>
		</div>
		<div class="item item-h2">
			<a href="/">
				<img src="/public/photos/cat3.jpg">
			</a>
			<div class="item-label">
				<div class="item-detail_container">
					<a href="/" class="item-title">It's my cat</a>
					<a href="/">23 Comments</a>
				</div>
				<div class="">Posted on <a href="/">cats</a> by <a href="/">l33t_pie</a></div>
			</div>
		</div>
		<div class="item item-v2">
			<a href="/">
				<img src="/public/photos/cat4.jpg">
			</a>
			<div class="item-label">
				<div class="item-detail_container">
					<a href="/" class="item-title">It's my cat</a>
					<a href="/">23 Comments</a>
				</div>
				<div class="">Posted on <a href="/">cats</a> by <a href="/">l33t_pie</a></div>
			</div>
		</div>
		<div class="item">
			<a href="/">
				<img src="/public/photos/cat5.jpg">
			</a>
			<div class="item-label">
				<div class="item-detail_container">
					<a href="/" class="item-title">It's my cat</a>
					<a href="/">23 Comments</a>
				</div>
				<div class="">Posted on <a href="/">cats</a> by <a href="/">l33t_pie</a></div>
			</div>
		</div>
		<div class="item item-v2">
			<a href="/">
				<img src="/public/photos/cat6.jpg">
			</a>
			<div class="item-label">
				<div class="item-detail_container">
					<a href="/" class="item-title">It's my cat</a>
					<a href="/">23 Comments</a>
				</div>
				<div class="">Posted on <a href="/">cats</a> by <a href="/">l33t_pie</a></div>
			</div>
		</div>
		<div class="item item-v3">
			<a href="/">
				<img src="/public/photos/cat7.jpg">
			</a>
			<div class="item-label">
				<div class="item-detail_container">
					<a href="/" class="item-title">It's my cat</a>
					<a href="/">23 Comments</a>
				</div>
				<div class="">Posted on <a href="/">cats</a> by <a href="/">l33t_pie</a></div>
			</div>
		</div>
		<div class="item item-h2">
			<a href="/">
				<img src="/public/photos/cat8.jpg">
			</a>
			<div class="item-label">
				<div class="item-detail_container">
					<a href="/" class="item-title">It's my cat</a>
					<a href="/">23 Comments</a>
				</div>
				<div class="">Posted on <a href="/">cats</a> by <a href="/">l33t_pie</a></div>
			</div>
		</div>
		<div class="item item-v2 item-h2">
			<a href="/">
				<img src="/public/photos/cat9.jpg">
			</a>
			<div class="item-label">
				<div class="item-detail_container">
					<a href="/" class="item-title">It's my cat</a>
					<a href="/">23 Comments</a>
				</div>
				<div class="">Posted on <a href="/">cats</a> by <a href="/">l33t_pie</a></div>
			</div>
		</div>
		<div class="item">
			<a href="/">
				<img src="/public/photos/cat10.jpg">
			</a>
			<div class="item-label">
				<div class="item-detail_container">
					<a href="/" class="item-title">It's my cat</a>
					<a href="/">23 Comments</a>
				</div>
				<div class="">Posted on <a href="/">cats</a> by <a href="/">l33t_pie</a></div>
			</div>
		</div>
		<div class="item item-v3 item-h2">
			<a href="/">
				<img src="/public/photos/cat11.jpg">
			</a>
			<div class="item-label">
				<div class="item-detail_container">
					<a href="/" class="item-title">It's my cat</a>
					<a href="/">23 Comments</a>
				</div>
				<div class="">Posted on <a href="/">cats</a> by <a href="/">l33t_pie</a></div>
			</div>
		</div>
		<div class="item item-v3">
			<a href="/">
				<img src="/public/photos/cat12.jpg">
			</a>
			<div class="item-label">
				<div class="item-detail_container">
					<a href="/" class="item-title">It's my cat</a>
					<a href="/">23 Comments</a>
				</div>
				<div class="">Posted on <a href="/">cats</a> by <a href="/">l33t_pie</a></div>
			</div>
		</div>
		<div class="item">
			<a href="/">
				<img src="/public/photos/cat13.jpg">
			</a>
			<div class="item-label">
				<div class="item-detail_container">
					<a href="/" class="item-title">It's my cat</a>
					<a href="/">23 Comments</a>
				</div>
				<div class="">Posted on <a href="/">cats</a> by <a href="/">l33t_pie</a></div>
			</div>
		</div>
		<div class="item item-h3 item-v2">
			<a href="/">
				<img src="/public/photos/cat14.jpg">
			</a>
			<div class="item-label">
				<div class="item-detail_container">
					<a href="/" class="item-title">It's my cat</a>
					<a href="/">23 Comments</a>
				</div>
				<div class="">Posted on <a href="/">cats</a> by <a href="/">l33t_pie</a></div>
			</div>
		</div>
		<div class="item item-h2">
			<a href="/">
				<img src="/public/photos/cat15.jpg">
			</a>
			<div class="item-label">
				<div class="item-detail_container">
					<a href="/" class="item-title">It's my cat</a>
					<span class="item-date">2 hours ago</span>
				</div>
				<div class="item-detail_container">
					<span>Posted on <a href="/">cats</a> by <a href="/">l33t_pie</a></span>
					<a href="/">23 Comments</a>
				</div>
			</div>
		</div> -->
	</div>
	<div class="grid-last">There seems to be nothing left...</div>
</main>

<?php include_once('../views/inc/sidebar.php'); ?>
<?php include_once('../views/inc/footer.php'); ?>