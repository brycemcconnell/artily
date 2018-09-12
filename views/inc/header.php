<?php

use App\Core\Request;



?>
<body>
<?php if (isset($_GET['status']) && $_GET['status'] == 'loggedout'): ?>
<div class="message">
	<div>Successfully logged out.</div>
	<button type="button" class="theme-btn message-btn" onclick="removeLogout();">X</button>
</div>
<script>
	function removeLogout() {
		if (document.querySelector('.message')) {
			document.querySelector('.message').remove();
		}
	}
	setTimeout(() => {
		removeLogout();
	}, 7000);
</script>
<?php endif; ?>
<header class="header">
	<a href="/" class="header-logo theme-btn"><!-- Logo (img/link) -->
		<span class="header-logo_text">artily</span>
	</a>
	<div class="header-content bb3">
		<div class="header-artboard_container"><!-- Artboard -->
			<!-- <img class="header-artboard_icon" src="/assets/img/test-artboard-icon.png"> -->
			<!-- Artboard icon -->
			<a class="header-artboard_name" href="<?= $board ?? '/' ?>"><?= $board ?? "Home"; ?></a><!-- Artboard name/link -->
		</div>
		<div class="header-search_container"><!-- Search Box -->
			<form>
				<input class="header-search_input" type="search" placeholder="Find something new...">
			</form>
		</div>
		<?php if (isset($_SESSION['user'])): ?>
		<div class="header-user_container"><!-- User dash -->
			<a href="/me" class="header-user">
				<img class="header-user_avatar" src="/assets/img/kermit.jpg"><!-- User pic -->
				<div class="header-user_details"><!-- Deets -->
					<div class="header-user_name"><?= $_SESSION['user']["username"]; ?></div><!-- User name -->
					<div><span class="heart">♥</span><span id="userHeartCount"><?= $this->user["userhearts"]; ?></span></div><!-- User heart count -->
				</div>
			</a>
			<a href="/messages" class="btn header-user_icon">
				<img src="/assets/img/mail.png">
			</a>
			<a href="/new_post" class="header-user_submit theme-btn theme-a-btn">
				Submit
			</a><!-- Submit new content -->
			<button type="button" class="btn header-user_icon" onclick="toggleUserMenu();">
				<?= $SVG->arrow_down(); ?>
			</button><!-- Other options, eg. preferences/logout -->
			<ul class="header-user_menu none-withjs floating-menu">
				<li>
					<a href="/account?action=preferences">
						<span class="svg-icon"><?= $SVG->arrow_down(); ?></span>Preferences
					</a>
				</li>
				<li>
					<a href="/account?action=logout&redirect=<?= $redirect; ?>">
						<span class="svg-icon"><?= $SVG->arrow_down(); ?></span>Logout
					</a>
				</li>
			</ul>
		</div>
		<?php else: ?>
		<div class="header-user_container">
			<a href="/account?action=login&redirect=<?= $redirect; ?>" class="header-user_login theme-btn">Login</a>
			<a href="/account?action=signup" class="header-user_login theme-btn">Signup</a>
		</div>
	</div>
	<?php endif;?>
	<script>
		function toggleUserMenu() {
			document.querySelector('.header-user_menu').classList.toggle('none-withjs');
		}
	</script>
</header>

