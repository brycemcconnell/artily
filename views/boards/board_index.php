<!-- <pre> -->
<?php

?>
<!-- </pre><br> -->
<!-- Wow i'm a board -->

<?php include_once('../views/inc/head.php'); ?>
<?php include_once('../views/inc/header.php'); ?>

<main class="main">

	<div id="main" class="grid grid--list">
		<?php
		foreach ($boards as $key => $value) {
			// render_post($posts[$key]);
			include('../views/boards/inc/board_list_item.php');
    }
    ?>
    
	</div>
	<div class="grid-last">There seems to be nothing left...</div>
</main>

<?php include_once('../views/common/board_sort.php'); ?>
<?php include_once('../views/inc/sidebar.php'); ?>
<?php include_once('../views/inc/footer.php'); ?>