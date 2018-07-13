<?php
include_once('../views/inc/head.php');
?>

<?php
	if (isset($_POST["submitPost"])) {
		print_r($_POST["submitPost"]);
		echo "Post recieved successfully";
	}
?>

<form action="post?action=new" method="POST" enctype="multipart/form-data" novalidate>
	<input type="text" name="title" placeholder="Title..." required>
	<input type="text" name="content" placeholder="Content here...">
	<input type="file" name="image">
	<button class="theme-btn" type="submit" name="submitPost">Submit</button>
</form>