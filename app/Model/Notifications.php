<?php
namespace App\Model;

include_once('app/Utils/Validation.php');

use PDO;
use App\Utils\Validation as Validation;

class Notifications
{
	private $pdo;

  public function __construct(\PDO $pdo)
  {
		$this->pdo = $pdo;
	}

  public function close(): void
  {
		$this->pdo = null;
  }

  public function user_getNotificationCount(int $user_id)
  {
    try {
      $sql = '
        SELECT
          COUNT(*) AS total,
          sum(viewed = 0) AS not_viewed
        FROM
          notifications
        WHERE
          receiver_id = :user_id
      ';
      $stmt = $this->pdo->prepare($sql);
      $stmt->bindValue(':user_id', $user_id, PDO::PARAM_INT);
      $stmt->execute();
      $result = $stmt->fetch();
      return $result;

    } catch(\PDOException $e) {
      echo "oops! an error getting the notification count<br><pre>";
      var_dump($e);
      echo "</pre>";
      die();
    }
  }

  public function user_getNotifications(int $user_id)
  {
    try {
      $sql = '
        SELECT
          notifications.*,
          users.username AS sender_username
        FROM
          notifications
        LEFT JOIN
          users
        ON
          notifications.sender_id = users.id
        WHERE
          receiver_id = :user_id
        ORDER BY
          notifications.time DESC
      ';
      $stmt = $this->pdo->prepare($sql);
      $stmt->bindValue(':user_id', $user_id, PDO::PARAM_INT);
      $stmt->execute();
      $result = $stmt->fetchAll();

      foreach ($result as $key => $value) {
        $result[$key]["elapsed"] = time_elapsed_string($result[$key]["time"]);
        $result[$key]["url"] = $result[$key]["controller"]."/".$result[$key]["trigger_id"];
      }
      return $result;

    } catch(\PDOException $e) {
      echo "oops! an error getting the notification count<br><pre>";
      var_dump($e);
      echo "</pre>";
      die();
    }
  }

  public function sendFrom(int $user_id, int $receiver_id)
  {
    try {
			$sql = '
				REPLACE INTO
          notifications		
				VALUES (
          null,
					:receiver_id,
					:sender_id,
          UTC_TIMESTAMP(),
          :trigger_type,
          :controller,
          :trigger_id,
          null,
          0
        );
      ';
			$stmt = $this->pdo->prepare($sql);
			$stmt->bindValue(':receiver_id', $receiver_id, PDO::PARAM_INT);
			$stmt->bindValue(':sender_id', $user_id, PDO::PARAM_INT);
			$stmt->bindValue(':trigger_type', $_POST["trigger_type"], PDO::PARAM_STR);
			$stmt->bindValue(':controller', $_POST["controller"], PDO::PARAM_STR);
			$stmt->bindValue(':trigger_id', $_POST["trigger_id"], PDO::PARAM_INT);
			$result = $stmt->execute();

			if ($result) {
				return $result;
			} else {
				return false;
			}
		} catch(\PDOException $e) {
			echo "My error: <br><pre>".$e->getMessage()."</pre>";
		}
  }
}