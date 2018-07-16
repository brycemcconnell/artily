<?php
namespace App\Model;

include_once('app/Utils/Validation.php');

use PDO;
use App\Utils\Validation as Validation;

class Posts {
	private $pdo;

	public function __construct(\PDO $pdo) {
		$this->pdo = $pdo;
	}

	public function close(): void {
		$this->pdo = null;
	}

	public function create_post(array $post) {
		$sql = '
			INSERT INTO
				posts (
				    title,
					created,
					artboard_id,
					user_id,
					file_path,
					file_name,
					file_type,
					nsfw,
					width,
					height
				)
			VALUES (
				:title,
				UTC_TIMESTAMP(),
				:artboard_id,
				:user_id,
				:file_path,
				:file_name,
				:file_type,
				:nsfw,
				:width,
				:height
			);
			INSERT INTO
				post_contents (
					post_id,
					content
				)
			VALUES (
				LAST_INSERT_ID(),
				:content
			)

		';
		$stmt = $this->pdo->prepare($sql);
		$stmt->bindValue(':title', $post["title"], PDO::PARAM_STR);
		$stmt->bindValue(':artboard_id', $post["artboard_id"], PDO::PARAM_STR);
		$stmt->bindValue(':user_id', $post["user_id"], PDO::PARAM_STR);
		$stmt->bindValue(':file_path', $post["file_path"], PDO::PARAM_STR);
		$stmt->bindValue(':file_name', $post["file_name"], PDO::PARAM_STR);
		$stmt->bindValue(':file_type', $post["file_type"], PDO::PARAM_STR);
		$stmt->bindValue(':nsfw', $post["nsfw"], PDO::PARAM_INT);
		$stmt->bindValue(':width', $post["width"], PDO::PARAM_INT);
		$stmt->bindValue(':height', $post["height"], PDO::PARAM_INT);
		$stmt->bindValue(':content', $post["content"], PDO::PARAM_STR);
		$stmt->execute();
		return $this->pdo->lastInsertId();
	}
	
	public function getPostsLatest() {
		$sql = '
			SELECT
				posts.created,
				posts.title,
				posts.artboard_id,
				posts.file_path,
				posts.file_name,
				posts.file_type,
				IF (posts.file_path IS NULL, LEFT (post_contents.content, 300), "") AS post_contents,
				posts.nsfw,
				posts.width,
				posts.height,
				posts.id as post_id,
				users.username,
				users.id as user_id,
				artboards.name as artboard_name,
				COUNT(comments.post_id) as comment_count
			FROM
				post_contents,
				artboards,
				users,
				posts
			LEFT JOIN
				comments ON posts.id = comments.post_id
			WHERE
				users.id = posts.user_id
			AND
				artboards.id = posts.artboard_id
			AND
				post_contents.post_id = posts.id
			GROUP BY
				posts.id, users.id
			ORDER BY 
				posts.created DESC
			LIMIT
				20;
		';
		$stmt = $this->pdo->prepare($sql);
		$stmt->execute();
		$post = $stmt->fetchAll();
		function get_image_ratio($width, $height) {
			if (!empty($width) && !empty($height))
				return $width / $height;
			return 1;
		}
		foreach ($post as $key => $value) {
			if (!empty($post[$key]["post_contents"]))
				$post[$key]["post_contents"] .= "...";
			$post[$key]["elapsed"] = time_elapsed_string($post[$key]["created"]);
			$post[$key]["post_url"] = "/board/".urlsafe($post[$key]["artboard_name"])."/post/".urlsafe($post[$key]["title"]);
			$post[$key]["user_url"] = "/user/".urlsafe($post[$key]["username"]);
			$post[$key]["ratio"] = get_image_ratio($post[$key]["width"], $post[$key]["height"]);
			$post[$key]["class"] = "";
			if ($post[$key]["ratio"] < .5)
				$post[$key]["class"] = "item-v2";
			else if ($post[$key]["ratio"] > 1.5)
				$post[$key]["class"] = "item-h2";
			else 
				if (rand(0,4) == 4)
					$post[$key]["class"] = "item-h2 item-v2";
			
		}
		return $post;

	}

	public function getPostById(int $post_id) {
		$sql = '
			SELECT
				posts.*,
				posts.id as post_id,
				users.username,
				users.id,
				post_contents.content,
				artboards.name as artboard_name
			FROM
				posts,
				artboards,
				users,
				post_contents
			WHERE
				posts.id = :post_id
			AND
				posts.user_id = users.id
			AND
				post_contents.post_id = :post_id
			AND
				artboards.id = posts.artboard_id;
		';
		$stmt = $this->pdo->prepare($sql);
		$stmt->bindValue(':post_id', $post_id, PDO::PARAM_INT);
		$stmt->execute();
		$post = $stmt->fetch();
		$post["elapsed"] = time_elapsed_string($post["created"]);
		$post["post_url"] = "/board/".urlsafe($post["artboard_name"])."/post/".urlsafe($post["title"]);
		$post["user_url"] = "/user/".urlsafe($post["username"]);
		return $post;
	}

	public function getPostByTitle(string $post_title) {
		
		$sql = '
			SELECT
				posts.*,
				posts.id as post_id,
				users.username,
				users.id,
				post_contents.content as post_contents,
				artboards.name as artboard_name
			FROM
				posts,
				artboards,
				users,
				post_contents
			WHERE
				posts.title = :post_title
			AND
				posts.user_id = users.id
			AND
				post_contents.post_id = posts.id
			AND
				artboards.id = posts.artboard_id;
		';
		$stmt = $this->pdo->prepare($sql);
		$stmt->bindValue(':post_title', urlsafereverse($post_title), PDO::PARAM_STR);
		$stmt->execute();
		$post = $stmt->fetch();
		$post["elapsed"] = time_elapsed_string($post["created"]);
		$post["post_url"] = "/board/".urlsafe($post["artboard_name"])."/post/".urlsafe($post["title"]);
		$post["user_url"] = "/user/".urlsafe($post["username"]);
		return $post;
	}
}