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
					board_id,
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
				:board_id,
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
		$stmt->bindValue(':board_id', $post["board_id"], PDO::PARAM_STR);
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

	public function userGetPostsLatest(int $user_id) {
		$sql = '
			SELECT
		   		Posts_All.*,
		   		(
			  		SELECT
				 		count(post_hearts.post_id)
					FROM
				 		post_hearts 
					WHERE
						(
							(post_hearts.user_id = :user_id) 
						AND
							(post_hearts.post_id = Posts_All.post_id)
						)
				) AS `user_hearted` 
			FROM
				Posts_All
			ORDER BY
				created DESC
			LIMIT
				20;
		';
		$stmt = $this->pdo->prepare($sql);
		$stmt->bindValue(':user_id', $user_id, PDO::PARAM_INT);
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
			$post[$key]["post_url"] = "/boards/".urlsafe($post[$key]["board_name"])."/posts/".urlsafe($post[$key]["title"]);
			$post[$key]["user_url"] = "/users/".urlsafe($post[$key]["username"]);
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
	
	public function getPostsLatest() {
		$sql = '
			SELECT * FROM `Posts_All`
			ORDER BY
				created DESC
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
			$post[$key]["post_url"] = "/boards/".urlsafe($post[$key]["board_name"])."/posts/".urlsafe($post[$key]["title"]);
			$post[$key]["perma_url"] = "/posts/".urlsafe($post[$key]["post_id"]);
			$post[$key]["user_url"] = "/users/".urlsafe($post[$key]["username"]);
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

	public function getPostsTrending() {
		$sql = '
			SELECT * FROM `Posts_All`
			ORDER BY 
				LOG10(heart_count + comment_count + 1) * 86400 / .3 + UNIX_TIMESTAMP(created) DESC
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
			$post[$key]["post_url"] = "/boards/".urlsafe($post[$key]["board_name"])."/posts/".urlsafe($post[$key]["title"]);
			$post[$key]["user_url"] = "/users/".urlsafe($post[$key]["username"]);
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
				posts.post_id as post_id,
				users.username,
				users.id,
				post_contents.content,
				boards.name as board_name
			FROM
				posts,
				boards,
				users,
				post_contents
			WHERE
				posts.post_id = :post_id
			AND
				posts.user_id = users.id
			AND
				post_contents.post_id = :post_id
			AND
				boards.id = posts.board_id;
		';
		$stmt = $this->pdo->prepare($sql);
		$stmt->bindValue(':post_id', $post_id, PDO::PARAM_INT);
		$stmt->execute();
		$post = $stmt->fetch();
		$post["op_id"] = $post["user_id"];
		$post["elapsed"] = time_elapsed_string($post["created"]);
		$post["post_url"] = "/boards/".urlsafe($post["board_name"])."/posts/".urlsafe($post["title"]);
		$post["user_url"] = "/users/".urlsafe($post["username"]);
		return $post;
	}

	public function getPostByTitle(string $post_title) {
		
		$sql = '
			SELECT
				posts.*,
				posts.post_id as post_id,
				users.username,
				users.id,
				post_contents.content as post_contents,
				boards.name as board_name
			FROM
				posts,
				boards,
				users,
				post_contents
			WHERE
				posts.title = :post_title
			AND
				posts.user_id = users.id
			AND
				post_contents.post_id = posts.post_id
			AND
				boards.id = posts.board_id;
		';
		$stmt = $this->pdo->prepare($sql);
		$stmt->bindValue(':post_title', urlsafereverse($post_title), PDO::PARAM_STR);
		$stmt->execute();
		$post = $stmt->fetch();
		$post["elapsed"] = time_elapsed_string($post["created"]);
		$post["post_url"] = "/boards/".urlsafe($post["board_name"])."/posts/".urlsafe($post["title"]);
		$post["user_url"] = "/users/".urlsafe($post["username"]);
		return $post;
	}


	/*
		@param int $id The post id.
		@return int 0 on failure, n as the amount of rows affected
	*/
	public function deletePostById(int $id)
	{
		$sql = '
			UPDATE
				posts
			SET
				deleted = UTC_TIMESTAMP()
			WHERE
				posts.post_id = :id
		';
		$stmt = $this->pdo->prepare($sql);
		$stmt->bindValue(':id', $id, PDO::PARAM_INT);
		$stmt->execute();
		return $stmt->rowCount();
	}
}