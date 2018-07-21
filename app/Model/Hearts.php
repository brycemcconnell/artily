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
				COUNT(*)
			FROM
				post_hearts
			WHERE
				user_id = :user_id;
		';
		$stmt = $this->pdo->prepare($sql);
		$stmt->bindValue(':user_id', $user_id, PDO::PARAM_INT);
		$stmt->execute();
		$hearts = $stmt->fetchColumn();
		return $hearts;
	}
}