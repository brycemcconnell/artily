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

			if ($result) {
				return $result;
			} else {
				return false;
			}
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