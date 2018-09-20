<?php include_once('../views/inc/head.php'); ?>
<?php include_once('../views/inc/header.php'); ?>

<?php
function renderNotification($item) {
  switch ($item["trigger_type"]) {
    case "post_heart":
      return "hearted your post";
    break;
    case "comment_heart":
      return "hearted your comment";
    break;
    case "comment_reply":
      return "replied to your comment ";
    break;
    case "comment":
      return "commented on one of your posts";
    break;
    default:
      return $item["custom_msg"];
    break;
  }
}
function renderTime($item) {
  return "&nbsp;<span class='time-tooltip' title='{$item["time"]}'>{$item["elapsed"]}</span>";
}
function renderUser($item) {
  return isset($item["sender_username"]) ? "<a href='/users/{$item["sender_username"]}' class='notification-user'>{$item["sender_username"]}</a>&nbsp;" : "";
}
?>

<main class="main">
  <section class="notification-section">
    This is the notification page.
    <div class="notification-container">
      <?php for ($i = 0; $i < count($notifications); $i++):?>
        <div class="notification-item <?= $notifications[$i]["viewed"] == 0 ? "notification-unread" : "";?>">
          <img src="/assets/img/kermit.jpg" class="notification-avatar">
          <?= renderUser($notifications[$i]);?><?= renderNotification($notifications[$i]);?><?= renderTime($notifications[$i]);?>
          <a href="/<?= $notifications[$i]["url"]; ?>" class="notification-link"></a>
          <div class="notification-checkbox">
            <input type="checkbox" id="n<?= $i;?>">
            <label for="n<?= $i;?>"></label>
          </div>
        </div>
      <?php endfor; ?>
      <div>
        <select>
          <option>Mark as read</option>
          <option>Delete</option>
        </select>
      </div>
    </div>
  </section>

</main>

<?php include_once('../views/inc/sidebar.php'); ?>
<?php include_once('../views/inc/footer.php'); ?>