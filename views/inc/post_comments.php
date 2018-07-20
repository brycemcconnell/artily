<?php 

/*

A recursive function for displaying nested comments

*/
function render_comments($elements, $op_id, $depth = 0) {
	foreach ($elements as $element):
		if ($element["parent_comment_id"] == NULL)
			$depth = 0;
		$user_comment = "";
		if (isset($_SESSION["user"]) && $element["user_id"] == $_SESSION["user"]["id"]) {
			$user_comment = "user_comment";
		} 
		$op_comment_class = "";
		if ($op_id == $element["user_id"]) {
			$op_comment_class = "cmt-op";
		}
		$comment_class = $depth == 0 ? "comment comment-top" : "comment";
		?>

		<ul id="c<?= $element["id"]; ?>" class="<?= $comment_class; ?>">
			<div class="cmt-vline"></div>
			<li class="comment-inner <?= $user_comment ?? ''; ?>">
				<button type="button" class="comment-collapse" onclick="collapseChildren(this);">[<span class="cmt-close">&#65291;</span><span class="cmt-open">&#65293;</span>]</button>
				<div class="comment-content">
					<?= nl2br($element["content"]); ?>
				</div>
				<div class="comment-menu">
					<span class="comment-hidden_helper">Hidden</span>
					<span><?= $element["elapsed"]; ?> by <a href="<?= $element["user_url"];?>" class="<?= $op_comment_class; ?>" ><?= $element["username"]; ?></a></span>
					<span class="cmt-dot">-</span>
					(<?= count($element["children"]); ?>) Replies
					<div class="comment-actions">
						<span class="cmt-dot">-</span>
						<?php if (!empty($user_comment)): ?>
							<a href="?action=edit&comment=<?= $element["id"]; ?>">Edit</a>
						<?php endif; ?>
						<a href="#c<?= $element["id"]; ?>">Permalink</a>
						<a href="/report?type=comment&id=<?= $element["id"]; ?>">Report</a>
						<a href="?action=reply&comment=<?= $element["id"]; ?>">Reply &#8617;</a>
					</div>
				</div>
			</li>
		<?php
		if (count($element["children"])) {
			$depth += 1;
			render_comments($element["children"], $op_id, $depth);
		}
		?>
</ul><?php
	endforeach; 
}
$op_id = $post["user_id"];
render_comments($comments, $op_id);