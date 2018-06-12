<?php

namespace App\Model;

include_once('app/Utils/Validation.php');

use PDO;
use App\Utils\Validation as Validation;

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
				users.username,
				users.password
			FROM
				users
			WHERE
				users.username = :username;
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

	public function createUser(string $username, string $password, string $email) {
		$oldUser = $this->getUser($username);
		if ($oldUser)
			// return 'Duplicate entry, someone with that name already exists.';
			return false;

		$validation = new Validation();
		$errors = [];
        $fields = [
            "username" => [$username, 'alpha_num', true],
            "password" => [$password, 'password', true],
            "email" => [$email, 'email', false]
        ];
        foreach ($fields as $key => $values) {
        	var_dump($values);
        	$message = $validation->validate(...$values);
        	var_dump($message);
        	if (strlen($message))
        		$errors[$key] = $message;
        }
        var_dump($errors);
        if ($errors) {
        	// return $errors;
        	return false;
        }

		$sql = '
			INSERT INTO
				users
			VALUES (
				DEFAULT,
				:username,
				:password,
				:email
			);
		';
		$stmt = $this->pdo->prepare($sql);
		$stmt->bindValue(':username', $username, PDO::PARAM_STR);
		$stmt->bindValue(':password', password_hash($password, PASSWORD_DEFAULT), PDO::PARAM_STR);
		$stmt->bindValue(':email', $email, PDO::PARAM_STR);
		$result = $stmt->execute();

		if ($result) {
			// return 'Account successfully created.';
			return true;
			var_dump($result);
		}
		else
			// return 'Account creation error.';
			return false;
	}

	public function getUser(string $username) {
		$sql = '
			SELECT
				id,
				username,
				email
			FROM
				users
			WHERE
				username = :username;
		';
		$stmt = $this->pdo->prepare($sql);
		$stmt->bindValue(':username', $username, PDO::PARAM_STR);
		$stmt->execute();
		$user = $stmt->fetch();
		return $user;
	}

	public function changePassword(string $username, string $currentpassword, string $newpassword) {
		$user = $this->authenticateUser($username, $currentpassword);
		if (!$user)
			return 'Authentication error.';

		$sql = '
			UPDATE
				users
			SET
				password = :password
			WHERE
				id = :id;
		';
		$stmt = $this->pdo->prepare($sql);
		$stmt->bindValue(':password', password_hash($newpassword, PASSWORD_DEFAULT), PDO::PARAM_STR);
		$stmt->bindValue(':id', $user["id"], PDO::PARAM_INT);
		$success = $stmt->execute();

		if ($success)
			return 'Password changed successfully.';
		else
			return 'An error occured.';
	}

	public function deleteUser(string $username, string $password) {
		$user = $this->authenticateUser($username, $password);
		if (!$user)
			return 'Authentication error.';

		$sql = '
			DELETE FROM
				users
			WHERE
				id = :id;
		';
		$stmt = $this->pdo->prepare($sql);
		$stmt->bindValue(':id', $user["id"], PDO::PARAM_INT);
		$success = $stmt->execute();

		if ($success)
			return 'Account deleted successfully, goodbye.';
		else
			return 'An error occured.';
	}
}