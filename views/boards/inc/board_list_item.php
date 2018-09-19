<?php

$board_data = $boards[$key];

// echo "<pre>";
// var_dump($board);
// echo "</pre>";
// die();
?>

<div class="item box bb">
    <div class="item-label">
    <a href="/boards/<?= $board_data["name"]; ?>" class="board_sidebar-title">
      <?= $board_data["name"]; ?>
    </a>
    <div>
      Created <span class="time-tooltip" title="<?= $board_data["created"]; ?>"><?= $board_data["elapsed"]; ?></span> by <a href="/users/<?= $board_data["created_by_name"]; ?>"><?= $board_data["created_by_name"]; ?></a>
    </div>
    <div>
      Description: <?= $board_data["description"]; ?>
    </div>
    <?= $board_data["nsfw"] ? "<div>NSFW</div>" : ""; ?>
    <div>
      Subscribers: <?= $board_data["board_subscription_count"]; ?>
    </div>
  </div>
  <a class="item-link" href="/boards/<?= $board_data["name"]; ?>"></a>
</div>