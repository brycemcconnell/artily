<?php

namespace App\Model;

use PDO;

class Boards {

	private $pdo;

  public function __construct(\PDO $pdo)
  {
		$this->pdo = $pdo;
	}

  public function close(): void
  {
		$this->pdo = null;
  }

  public function getBoardByName(string $board_name)
  {
    try {
      $sql = '
        SELECT
          boards.*,
          board_contents.description,
          users.username AS created_by_name,
          (
            SELECT
              Count(board_id)
            FROM
              board_subscriptions
            WHERE
              board_subscriptions.board_id = boards.id
          ) AS board_subscription_count
        FROM
          boards
        LEFT JOIN
          board_contents
        ON
          boards.id = board_contents.board_id
        LEFT JOIN
          board_subscriptions
        ON
          boards.id = board_subscriptions.board_id
        LEFT JOIN
          users
        ON
          boards.created_by = users.id
        WHERE
          name = :board_name;
      ';
      $stmt = $this->pdo->prepare($sql);
      $stmt->bindValue(':board_name', $board_name, PDO::PARAM_STR);
      $stmt->execute();
      $result = $stmt->fetch();
      
      $result["elapsed"] = time_elapsed_string($result["created"]);

      return $result;

    } catch(\PDOException $e) {
      echo "oops! an error getting the board info<br><pre>";
      var_dump($e);
      echo "</pre>";
      die();
    }
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

    } catch(\PDOException $e) {
      echo "oops! an error getting the board posts<br><pre>";
      var_dump($e);
      echo "</pre>";
      die();
    }
  }

}