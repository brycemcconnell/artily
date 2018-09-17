<!-- <pre> -->
<?php

?>
<!-- </pre><br> -->
<!-- Wow i'm a user page -->

<?php include_once('../views/inc/head.php'); ?>
<?php include_once('../views/inc/header.php'); ?>
<script src="/assets/js/heartPost.js"></script>
<main class="main">

	<div id="main" class="grid grid--list">
    <div class="box bb">
      <div>Name: <?=$user["username"];?></div>
      <div>Created <span class="time-tooltip" title="<?=$user["created"];?>"><?=$user["elapsed"];?></span></div>
      <div>Title: <?= $user["title"]; ?></div>
    </div>
    <div class="box bb">
      Posts by <?=$user["username"];?>
    </div>
    <div>
      <?php
      foreach ($posts as $key => $value) {
        include('../views/home/inc/board_post.php');
      }
      ?>
    </div>
    
	</div>
	<div class="grid-last">There seems to be nothing left...</div>
</main>

<?php include_once('../views/common/board_sort.php'); ?>
<?php include_once('../views/inc/sidebar.php'); ?>
<?php include_once('../views/inc/footer.php'); ?>