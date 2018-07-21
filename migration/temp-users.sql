SELECT users.id, users.email, users.username, users.created, users.deleted, users.level, (SELECT COUNT(post_hearts.user_id) FROM post_hearts WHERE post_hearts.user_id = users.id) as post_heart_count, (SELECT COUNT(comment_hearts.user_id) FROM comment_hearts WHERE comment_hearts.user_id = users.id) as comment_heart_count,

(SELECT COUNT(posts.user_id) FROM posts WHERE posts.user_id = users.id) as post_count,
(SELECT COUNT(comments.user_id) FROM comments WHERE comments.user_id = users.id) as comment_count,
(SELECT COUNT(collections.user_id) FROM collections WHERE collections.user_id = users.id) as collection_count,
 
 FROM `users`