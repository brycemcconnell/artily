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

	private	function get_image_ratio($width, $height) {
		if (!empty($width) && !empty($height))
			return $width / $height;
		return 1;
	}

	private function createPostData ($item) {
		if (!empty($item["post_contents"]))
			$item["post_contents"] .= "...";
		$item["elapsed"] = time_elapsed_string($item["created"]);
		$item["post_url"] = "/boards/".urlsafe($item["board_name"])."/posts/".urlsafe($item["title"]);
		$item["perma_url"] = "/posts/".urlsafe($item["post_id"]);
		$item["user_url"] = "/users/".urlsafe($item["username"]);
		$item["ratio"] = $this->get_image_ratio($item["width"], $item["height"]);
		$item["class"] = "";
		if ($item["ratio"] < .5)
			$item["class"] = "item-v2";
		else if ($item["ratio"] > 1.5)
			$item["class"] = "item-h2";
		else 
			if (rand(0,4) == 4)
				$item["class"] = "item-h2 item-v2";
		return $item;
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

	public function getPostsByUserId(int $user_id)
	{
		{
			try {
				if (isset($_SESSION["user"])) {
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
					WHERE
					user_id = :user_id
					ORDER BY
						created DESC
					LIMIT
						20;
					';
				} else {
					$sql = '
						SELECT
							*
						FROM
							Posts_All
						WHERE
							user_id = :user_id
						ORDER BY
							created DESC
						LIMIT
							20;
					';
				}
				
				$stmt = $this->pdo->prepare($sql);
				$stmt->bindValue(':user_id', $user_id, PDO::PARAM_INT);
				$stmt->execute();
				$post = $stmt->fetchAll();
	
				foreach ($post as $key => $value) {
					$post[$key] = $this->createPostData($post[$key]);			
				}
	
				return $post;
	
			} catch(\PDOException $e) {
				echo "oops! an error getting the board posts<br><pre>";
				var_dump($e);
				echo "</pre>";
				die();
			}
		}
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
		
		foreach ($post as $key => $value) {
			$post[$key] = $this->createPostData($post[$key]);			
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

		foreach ($post as $key => $value) {
			$post[$key] = $this->createPostData($post[$key]);			
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

		foreach ($post as $key => $value) {
			$post[$key] = $this->createPostData($post[$key]);			
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

	public function getBoardPostsById(int $board_id)
  {
    try {
      $sql = '
        SELECT
          *
        FROM
          Posts_All
        WHERE
          board_id = :board_id
        ORDER BY
				  created DESC
			  LIMIT
				  20;
      ';
      $stmt = $this->pdo->prepare($sql);
      $stmt->bindValue(':board_id', $board_id, PDO::PARAM_INT);
      $stmt->execute();
      $post = $stmt->fetchAll();

      foreach ($post as $key => $value) {
				$post[$key] = $this->createPostData($post[$key]);			
			}

      return $post;

    } catch(\PDOException $e) {
      echo "oops! an error getting the board posts<br><pre>";
      var_dump($e);
      echo "</pre>";
      die();
    }
  }

  public function userGetBoardPostsById(int $user_id, int $board_id)
  {
    try {
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
      WHERE
        board_id = :board_id
			ORDER BY
				created DESC
			LIMIT
				20;
      ';
      $stmt = $this->pdo->prepare($sql);
      $stmt->bindValue(':user_id', $user_id, PDO::PARAM_INT);
      $stmt->bindValue(':board_id', $board_id, PDO::PARAM_INT);
      $stmt->execute();
      $post = $stmt->fetchAll();

      foreach ($post as $key => $value) {
				$post[$key] = $this->createPostData($post[$key]);			
			}

      return $post;

    } catch(\PDOException $e) {
      echo "oops! an error getting the board posts<br><pre>";
      var_dump($e);
      echo "</pre>";
      die();
    }
  }
}