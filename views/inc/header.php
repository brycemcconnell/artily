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
			<form class="header-search_form">
				<input class="header-search_input" type="search" placeholder="Find something new...">
				<button class="header-search_input-btn">
					<?= $SVG->search();?>
				</button>
			</form>
		</div>
		<?php if (isset($_SESSION['user'])): ?>
		<div class="header-user_container"><!-- User dash -->
			<a href="/me" class="header-user">
				<img class="header-user_avatar" src="/assets/img/kermit.jpg"><!-- User pic -->
				<div class="header-user_details"><!-- Deets -->
					<div class="header-user_name"><?= $_SESSION['user']["username"]; ?></div><!-- User name -->
					<div><span class="heart">♥</span><span id="userHeartCount"><?= $this->user["userhearts"] ?? "0"; ?></span></div><!-- User heart count -->
				</div>
			</a>
			<a href="/notifications" class="btn header-user_icon">
				<div class="svg-icon">
					<?= $SVG->bell();?>
					<?php if ($this->user["notifications"]["not_viewed"] != 0): ?>
						<div class="header-notification_count">
							<?= $this->user["notifications"]["not_viewed"]; ?>
						</div>
					<?php endif; ?>
				</div>
			</a>
			<a href="/messages" class="btn header-user_icon">
				<div class="svg-icon">	
					<?= $SVG->mail(); ?>
				</div>
			</a>
			<!-- Submit new content -->
			<a href="/new_post" class="header-user_submit theme-btn theme-a-btn">
				<span class="n900">Create Post</span>
				<span class="header-user_submit-sp y900"><?= $SVG->pencil();?></span>
			</a>
			<!-- Open options -->
			<button type="button" class="btn header-user_icon header-drop_down_btn" onclick="toggleUserMenu();">
				<?= $SVG->arrow_down(); ?>
			</button>
			<!-- Other options, eg. preferences/logout -->
			<ul class="header-user_menu none-withjs floating-menu">
				<li>
					<a href="/account/preferences">
						<span class="svg-icon"><?= $SVG->arrow_down(); ?></span>Preferences
					</a>
				</li>
				<li>
					<a href="/logout?<?= $redirect; ?>">
						<span class="svg-icon"><?= $SVG->arrow_down(); ?></span>Logout
					</a>
				</li>
			</ul>
		</div>
		<?php else: ?>
		<div class="header-user_container">
			<a href="/login?<?= $redirect; ?>" class="header-user_login theme-btn">Login</a>
			<a href="/signup?<?= $redirect; ?>" class="header-user_signup theme-btn">Signup</a>
		</div>
	</div>
	<?php endif;?>
	<script>
		function toggleUserMenu() {
			document.querySelector('.header-user_menu').classList.toggle('none-withjs');
		}
	</script>
</header>
<div class="shadow"></div>

