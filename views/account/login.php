<?php include_once('../views/inc/head.php'); ?>

<?php 
	/*

	After a successful account creation, the user will be redirected here.

	*/
	if (isset($_GET["status"]) && $_GET["status"] == "accountCreated"):
?>
	<div class="row text-center text-danger">
		Account created successfully. Please login.
	</div>
<?php endif; ?>

<a href="/" class="home-btn theme-btn theme-a-btn">
	<img src="/assets/img/home.svg">
</a>
<main class="login-page">
	<img src="/assets/img/kermit.jpg">
	<form action="/login?<?= $redirect; ?>" method="POST" novalidate>
		<div class="login-input_container">
			<?php 
			if (isset($_GET["redirect"])) {
				echo '<input type="hidden" name="redirect" value="'.$_GET["redirect"].'"/>'; 
			} ?>
			<input class="login-input" type="text" name="username" placeholder="Username..." value="<?= $username ?? ''; ?>" required>
			<input class="login-input" type="password" name="password" placeholder="Password..." required>
			<button class="theme-btn" type="submit" name="submitLogin">Sign In</button>
		</div>
	</form>

	<?php if (isset($password_is_valid) && $password_is_valid === false): ?>
	    <div class="row text-center text-danger">Login failure. Username/password combination invalid</div>
	<?php endif; ?>
</main>
