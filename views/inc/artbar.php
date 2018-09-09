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
<style>
	.artbar {
		padding: 0;
	}
	.artbar-contents {
		padding: 2vw;
	}
	.artbar-title {
		display: block;
		background-color: var(--main-color);
		transition: background-color .3s;
		color: #fff;
		font-weight: bold;
		font-size: 24px;
		padding: 8px 2vw;
	}

	.artbar-title:hover {
		color: #fff;
		background-color: var(--main-color-highlight);
	}

	.time-tooltip:hover {
		font-style: italic;
	}
</style>