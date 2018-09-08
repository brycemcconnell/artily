<?php include_once('../views/inc/head.php'); ?>
<a href="/" class="home-btn theme-btn theme-a-btn"><img src="/assets/img/home.svg"></a>
<main class="signup-page">
	<img src="/assets/img/kermit.jpg">
	<form action="account?action=signup" method="POST" novalidate>
		<div class="signup-input_container">
			<input class="signup-input" type="text" name="username" placeholder="..." value="<?= $username ?? ''; ?>" required>
			<input class="signup-input" type="email" name="email" placeholder="Email..." value="<?= $email ?? ''; ?>" required>
			<input class="signup-input" type="password" name="password" placeholder="Password..." required>
			<button class="theme-btn" type="submit" name="submitsignup">Sign Up</button>
		</div>
	</form>

	<?php if ($signup_success === false): ?>
	    <div class="row text-center text-danger">Signup failure.</div>
	    <?php isset($userCreation["errors"]) ? var_dump($userCreation) : ""; ?>
	<?php endif; ?>
</main>
