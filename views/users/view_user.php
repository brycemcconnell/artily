<!-- <pre> -->
<?php

?>
<!-- </pre><br> -->
<!-- Wow i'm a user page -->

<?php include_once('../views/inc/head.php'); ?>
<?php include_once('../views/inc/header.php'); ?>
<script src="/assets/js/heartPost.js"></script>
<main class="main">
  <div class="user-container box">
    <div class="user-avatar">
      <img src="/assets/img/kermit.jpg">
    </div>
    <div>
      <div>Name: <?=$user["username"];?></div>
      <div>Created <span class="time-tooltip" title="<?=$user["created"];?>"><?=$user["elapsed"];?></span></div>
      <div>Title: <?= $user["title"]; ?></div>
   </div>
  </div>
  <ul class="user-items box">
    <li><a href="<?= $_SERVER["REQUEST_URI"];?>/posts" class="user-items-item user-items-item--active">Posts</a></li>
    <li><a href="<?= $_SERVER["REQUEST_URI"];?>/comments" class="user-items-item">Comments</a></li>
    <li><a href="<?= $_SERVER["REQUEST_URI"];?>/boards" class="user-items-item">Boards</a></li>
    <li><a href="<?= $_SERVER["REQUEST_URI"];?>/collections" class="user-items-item">Collections</a></li>
  </ul>
  <?php include_once('../views/common/board_sort.php'); ?>
	<div id="main" class="grid grid--list">    
      <?php
      foreach ($posts as $key => $value) {
        include('../views/home/inc/board_post.php');
      }
      ?>    
	</div>
	<div class="grid-last">There seems to be nothing left...</div>
</main>


<?php include_once('../views/inc/sidebar.php'); ?>
<?php include_once('../views/inc/footer.php'); ?>