<?php include_once('inc/head.php');?>
<?php if (isset($error)): ?>
<main class="error_page">
	<p class="error_code"><?= key($error); ?></p>
	<p class="error_message"><?= $error[key($error)]; ?></p>
	<a href="/">Return home</a>
</main>
	<?php endif; ?>