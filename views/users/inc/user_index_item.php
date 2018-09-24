<?php

$user_data = $users[$key];

// echo "<pre>";
// var_dump($user);
// echo "</pre>";
// die();
?>

<div class="item box bb">
    <div class="item-label">
    <a href="/users/<?= $user_data["username"]; ?>" class="board_sidebar-title">
      <?= $user_data["username"]; ?>
    </a>
    <div>
      Created account <span class="time-tooltip" title="<?= $user_data["created"]; ?>"><?= $user_data["elapsed"]; ?></span>
    </div>
    <div>
      User heart count: <?= $user_data["heart_count"] ?? "0"; ?>
    </div>
  </div>
  <a class="item-link" href="/users/<?= $user_data["username"]; ?>"></a>
</div>