<?php

namespace App\Model;

use PDO;

class Users {
	private $pdo;

	public function __construct(\PDO $pdo) {
		$this->pdo = $pdo;
	}

	public function close(): void {
		$this->pdo = null;
	}

	public function authenticateUser(string $username, string $password) {
		$sql = '
			SELECT
				users.id,
				users.username,
				users.email,
				users.password
			FROM
				users
			WHERE
				users.username = :username
		';
		$stmt = $this->pdo->prepare($sql);
		$stmt->bindValue(':username', $username, PDO::PARAM_STR);
		$stmt->execute();

		$user = $stmt->fetch();

		if ($user && password_verify($password, $user['password'])) {
			unset($user['password']);
			return $user;
		}
		return false;
	} 
}