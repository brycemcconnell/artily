<?php 

/*

A recursive function for displaying nested comments

*/
function render_comments($elements, $depth = 0) {
	foreach ($elements as $element):
		if ($element["parent_comment_id"] == NULL)
			$depth = 0;
		$user_comment = $element["user_id"] == $_SESSION["user"]["id"] ? "user_comment" : "";
		$comment_class = $depth == 0 ? "comment comment-top" : "comment";
		?>
		<div id="c<?= $element["id"]; ?>" class="<?= $comment_class; ?>">
			<div class="cmt-vline"></div>
			<div class="comment-inner <?= $user_comment ?? ''; ?>">
				<button type="button" class="comment-collapse" onclick="collapseChildren(this);">[<span class="cmt-close">&#65291;</span><span class="cmt-open">&#65293;</span>]</button>
				<div class="comment-content">
					<!-- {<?= $element["id"]; ?>} -->
					<!-- <?= $element["post_id"]; ?> -->
					
					<!-- <?= $element["user_id"]; ?> -->
					<!-- <?= $element["parent_comment_id"]; ?> -->
					
					<?= nl2br($element["content"]); ?>
					<!-- <?= (int)$depth; ?> -->
				</div>
				<div class="comment-menu">
					<span class="comment-hidden_helper">Hidden</span>
					<span><?= $element["elapsed"]; ?> by <a href="<?= $element["user_url"]; ?>"><?= $element["username"]; ?></a></span>
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
			</div>
		<?php
		if (count($element["children"])) {
			$depth += 1;
			render_comments($element["children"], $depth);
		}
		?></div><?php
	endforeach; 
} 
render_comments($comments);