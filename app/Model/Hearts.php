<?php
namespace App\Model;

include_once('app/Utils/Validation.php');

use PDO;
use App\Utils\Validation as Validation;

class Hearts {
	private $pdo;

	public function __construct(\PDO $pdo) {
		$this->pdo = $pdo;
	}

	public function close(): void {
		$this->pdo = null;
	}

	public function getHeartsByUserId(int $user_id) {
		$sql = '
			SELECT
				SUM(heart_count)
			FROM
				Posts_All
			WHERE
				user_id = :user_id;
		';
		$stmt = $this->pdo->prepare($sql);
		$stmt->bindValue(':user_id', $user_id, PDO::PARAM_INT);
		$stmt->execute();
		$hearts = $stmt->fetchColumn();
		return $hearts;
	}

	public function addPostHeart(int $user_id, int $post_id)
	{
		try {
			$this->pdo->beginTransaction();
			// Add the heart entry
			$sql = '
				INSERT IGNORE INTO
					post_hearts			
				VALUES (
					:user_id,
					:post_id,
					UTC_TIMESTAMP()
				);
			';
			$stmt = $this->pdo->prepare($sql);
			$stmt->bindValue(':user_id', $user_id, PDO::PARAM_INT);
			$stmt->bindValue(':post_id', $post_id, PDO::PARAM_INT);
			$result = $stmt->execute();
			
			if ($result == false) { // If the heart can't be added 
				$this->pdo->rollBack();
				return [
					"success" => false,
					"message" => "The post couldn't be hearted"
				];
			}
			$stmt = null;
			$result = false;

			// Get the OP user id
			$sql = '
				SELECT
					posts.user_id	
				FROM
					posts
				WHERE
					posts.post_id = :post_id;
			';
			$stmt = $this->pdo->prepare($sql);
			$stmt->bindValue(':post_id', $post_id, PDO::PARAM_INT);
			$result = $stmt->execute();
			$receiver_id = (int)$stmt->fetch()["user_id"];
			// var_dump($receiver_id);
			
			if ($result == false) { // If the user isnt found
				// Still add a heart to the post, but don't send any notification
				$this->pdo->commit();
				return [
					"success" => true,
					"message" => "Hearted successfully, but original poster not found, oh well"
				];
			}
			
			$stmt = null;
			$result = false;

			$sql = '
				INSERT INTO
					notifications		
				VALUES (
					null,
					:sender_id,
					UTC_TIMESTAMP(),
					:trigger_type,
					:controller,
					:trigger_id,
					null
				);
			';
			
			$stmt = $this->pdo->prepare($sql);
			// 
			$stmt->bindValue(':sender_id', $user_id, PDO::PARAM_INT);
			$stmt->bindValue(':trigger_type', "post_heart", PDO::PARAM_STR);
			$stmt->bindValue(':controller', "posts", PDO::PARAM_STR);
			$stmt->bindValue(':trigger_id', $post_id, PDO::PARAM_INT);
			$result = $stmt->execute();

			if ($result == false) {
				$this->pdo->rollBack();
				return [
					"success" => false,
					"message" => "Couldn't update notifications"
				];
			}

			$last_insert = $this->pdo->lastInsertId();

			$stmt = null;
			$result = false;

			$sql = '
			INSERT INTO
				notification_recipients
			VALUES (
				null,
				:last_insert,
				:receiver_id,
				0);
			';
			$stmt = $this->pdo->prepare($sql);
			$stmt->bindValue(':receiver_id', $receiver_id, PDO::PARAM_INT);
			$stmt->bindValue(':last_insert', $last_insert, PDO::PARAM_INT);
			$result = $stmt->execute();

			// Successfully sent the message
			$this->pdo->commit();
			return [
				"success" => true,
				"message" => "Successfully hearted and notification sent"
			];
		} catch(PDOException $e) {
			echo "My error: <br><pre>".$e->getMessage()."</pre>";
		}
	}

	public function removePostHeart(int $user_id, int $post_id)
	{
		try {
			$sql = '
				DELETE FROM
					post_hearts			
				WHERE
					user_id = :user_id
				AND
					post_id = :post_id
			';
			$stmt = $this->pdo->prepare($sql);
			$stmt->bindValue(':user_id', $user_id, PDO::PARAM_INT);
			$stmt->bindValue(':post_id', $post_id, PDO::PARAM_INT);
			$result = $stmt->execute();

			if ($result) {
				return $result;
			} else {
				return false;
			}
		} catch(PDOException $e) {
			echo "My error: <br><pre>".$e->getMessage()."</pre>";
		}
	}

	public function heartComment(int $user_id, int $comment_id)
	{

	}
}