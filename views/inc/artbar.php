<?php
/* 

*/

?>

<aside class="artbar box bb">
	<a href="/boards/<?= $board_data["name"]; ?>" class="artbar-title"><?= $board_data["name"]; ?><br></a>
	<div class="artbar-contents">
		Since creation: <br>
		Description: <?= $board_data["description"]; ?><br>
		<?= $board_data["nsfw"] ? "NSFW<br>" : ""; ?>
		Subscribers: <?= $board_data["board_subscription_count"]; ?><br>
		Created <span class="time-tooltip" title="<?= $board_data["created"]; ?>"><?= $board_data["elapsed"]; ?></span> by <a href="/users/<?= $board_data["created_by_name"]; ?>"><?= $board_data["created_by_name"]; ?></a>
	</div>
</aside>