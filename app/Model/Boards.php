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

  public function getBoards()
  {
    try {
      // Note: Distinct here is kind of hacky, really we want the query to return the correct number of rows either way
      // Perhaps this is because of the subquery, or the joins, not sure
      $sql = '
        SELECT DISTINCT
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
      ';
      $stmt = $this->pdo->prepare($sql);
      $stmt->execute();
      $result = $stmt->fetchAll();
      
      for ($i=0; $i < count($result); $i++) { 
        $result[$i]["elapsed"] = time_elapsed_string($result[$i]["created"]);

      }

      return $result;

    } catch(\PDOException $e) {
      echo "oops! an error getting the board info<br><pre>";
      var_dump($e);
      echo "</pre>";
      die();
    }
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

      if ($result == false) {
        return false;
      }
      
      $result["elapsed"] = time_elapsed_string($result["created"]);

      return $result;

    } catch(\PDOException $e) {
      echo "oops! an error getting the board info<br><pre>";
      var_dump($e);
      echo "</pre>";
      die();
    }
  }

}