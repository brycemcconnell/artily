<?php
include_once('../views/inc/head.php');
?>

<?php
	if (isset($_POST["submitPost"])) {
		print_r($_POST["submitPost"]);
		echo "Post recieved successfully";
	}
?>
<?php include_once('../views/inc/header.php');?>
<main class="main">
	<form class="post-new_form box bb" action="" method="POST" enctype="multipart/form-data" novalidate>
	<div>Submit a new post</div>
	<?php if (isset($board)): ?>
		<div>Posting to: <input class="input-text" type="text" name="board" value="<?= $board; ?>" readonly></div>
	<?php else: ?>
		<div><span>Post to:</span> <input class="input-text" type="text" name="board"></div>
	<?php endif; ?>
		
		<div>
			<input class="input-text" type="text" name="title" placeholder="Title..." required>
		</div>
		<div>
			<textarea class="input-text input-textarea" name="content" placeholder="Content here..."></textarea>
		</div>
		<div>
			<input type="file" name="image">
		</div>
		<div>
			<input type="checkbox" name="nsfw" id="nsfw">
			<label for="nsfw">Mark as a NSFW post? (18+ content)</label>
		</div>
		<div class="post-action_row">
			<button class="btn theme-btn theme-btn-default btn-secondary" type="submit" name="savepost">Save</button>
			<button class="btn theme-btn theme-btn-default btn-secondary" type="submit" name="discardpost">Discard</button>
			<button class="btn theme-btn theme-btn-default" type="submit" name="submitPost">Submit Post</button>
		</div>
	</form>
</main>
<?php include_once('../views/inc/sidebar.php');?>
<?php include_once('../views/inc/footer.php');?>