<?php include_once('inc/head.php'); ?>
<a href="/" class="home-btn theme-btn theme-a-btn"><img src="/public/assets/img/home.svg"></a>
<main class="login-page">
	<img src="/public/assets/img/kermit.jpg">
	<form action="?action=login" method="POST" novalidate>
		<div class="login-input_container">
			<input class="login-input" type="text" name="username" placeholder="Username..." value="<?= $username ?? ''; ?>" required>
			<input class="login-input" type="password" name="password" placeholder="Password..." required>
			<button class="theme-btn" type="submit" name="submitLogin">Sign In</button>
		</div>
	</form>

	<?php if ($password_is_valid === false): ?>
	    <div class="row text-center text-danger">Login failure. Username/password combination invalid</div>
	<?php endif; ?>
</main>
