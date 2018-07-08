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

	public function getUserByEmail(string $email) {
		$sql = '
			SELECT
				id,
				username,
				email
			FROM
				users
			WHERE
				email = :email;
		';
		$stmt = $this->pdo->prepare($sql);
		$stmt->bindValue(':email', $email, PDO::PARAM_STR);
		$stmt->execute();
		$user = $stmt->fetch();
		return $user;
	}

	public function createUser(string $username, string $password, string $email) {
		/*

		I have split the error checking into two, in order to cancel needless database 
		queries when the post data was incorrect in the first place

		*/

		$errors = [];
		// If no email was input
		if ($email === '') 
				$email = null;


		// Check if the post data is valid first, return errors

		function validate($item) {
			return $item;
		}

		// Username must be alpha-numeric, 1-30 characters
		// email must be an email, php function?
		// password must be 8-255 characters and have at least one non lowercase alphabetical character (number/symbol)

		$username = validate($username);
		if ($email !== null) 
			$email  = validate($email);
		$password = validate($password);

		if (count($errors)) {
			return [
				"status" => false,
				"errors" => $errors
			];
		}

		// The post data was all correct, now check against the database if username/email is already in use.
		$oldUser = '';
		$oldUser = $this->getUser($username);
		if ($oldUser) {
			// return 'Duplicate entry, someone with that name already exists.'
			var_dump("old user present");
			$errors["oldUser"] = true;
		}
		
		$oldEmail = '';
		if ($email !== null) 
			$oldEmail = $this->getUserByEmail($email);
		if ($oldEmail) {
			// return 'Duplicate entry, someone with that email already exists.'
			var_dump("old email present");
			$errors["oldEmail"] = true;
		}

		if (count($errors)) {
			return [
				"status" => false,
				"errors" => $errors
			];
		}

		// Data was all correct, attempt to create database entry.
		$sql = '
			INSERT INTO
				users
				(
					username,
					email,
					password,
					created
				)
			VALUES (
				:username,
				:email,
				:password,
				UTC_TIMESTAMP()
			);
		';
		$stmt = $this->pdo->prepare($sql);
		$stmt->bindValue(':username', $username, PDO::PARAM_STR);
		$stmt->bindValue(':password', password_hash($password, PASSWORD_DEFAULT), PDO::PARAM_STR);
		$stmt->bindValue(':email', $email, PDO::PARAM_STR);
		$result = $stmt->execute();
		var_dump($result);
		if ($result) {
			// return 'Account successfully created.';
			return ["status" => true];
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