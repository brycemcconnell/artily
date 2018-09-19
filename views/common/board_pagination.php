<?php
  $current_page = 0;
  if (isset($_GET["page"])) {
    $current_page = $_GET["page"];
  }
?>
<div class="grid-last">
  <?php if ($page_count): ?>
    <?php for ($i= 0; $i < ceil($page_count/20); $i++): ?>
      <a href="?page=<?= $i ?>" class="page <?= $i == $current_page ? "page--active" : "" ?>"><?= $i ?></a>
    <?php endfor; ?>
  <?php else: ?>
  there should be apagecount
  <?php endif; ?>
</div>
<!-- JS ONLY -->
<!-- <div class="grid-last">There seems to be nothing left...</div> -->