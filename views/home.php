<?php include_once('inc/svg.php'); ?>
<?php include_once('inc/head.php'); ?>
<?php include_once('inc/header.php'); ?>


<?php include_once('inc/sidebar.php'); ?>
<main class="main">
	<div class="grid sidebar-open_margins">
		<?php 
		if (isset($_GET["artboard"])) {
			// Check if entry exists
			// if (exists) {
				// Show only posts from x artboard
				echo $_GET["artboard"];
			// } else {
				// Show error
			// }
		}
		else if (isset($_GET["user"])) {
			// Check if entry exists
			// if (exists) {
				// Show x user
				echo $_GET["user"];
			// } else {
				// Show error
			// }
		}
		else if (isset($_GET["collection"])) {
			// Check if entry exists
			// if (exists) {
				// Show x collection
				echo $_GET["collection"];
			// } else {
				// Show error
			// }
		}
		else if (isset($_GET["post"])) {
			// Check if entry exists
			// if (exists) {
				// Show x post
				echo $_GET["post"];
			// } else {
				// Show error
			// }
		}
		else {
			// Show all posts
			?>
			<div class="item"></div>
			<div class="item item3x2"></div>
			<div class="item"></div>
			<div class="item item4x4"></div>
			<div class="item item2x3"></div>
			<div class="item item2x3"></div>
			<div class="item"></div>
			<div class="item item3x2"></div>
			<div class="item item4x4"></div>
			<div class="item"></div>
			<div class="item"></div>
			<div class="item"></div>
			<div class="item"></div>
			<div class="item"></div>
			<?php
		}
		?>
		<div class="grid-last">There seems to be nothing left...</div>
	</div>

</main>
<?php include_once('inc/footer.php'); ?>