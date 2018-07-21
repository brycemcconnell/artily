<?php


namespace App\Controller;

Use App\Model\Users as Users;

class AccountController {
	private $db;

	public function __construct(Users $db) {
		$this->db = $db;
	}

	public function run(): void
	{
		if (isset($_GET["action"])) {
			switch ($_GET["action"]) {
				case 'login':
					$this->login();
					return;
				break;
				case 'logout':
					$this->logout();
					return;
				break;
				case 'signup':
					$this->signup();
					return;
				break;
			}
        }
        header("Location: /error?code=404");
   		die();
	}

	public function login(): void
	{
		$password_is_valid = true; //assumed true for first run

		if (array_key_exists('user',$_SESSION)) {
			redirect_back();
			die();
		}

		if (isset($_POST['submitLogin'])) {
			$password = filter_input(INPUT_POST, 'password');
			$username = filter_input(INPUT_POST, 'username');
			$user = $this->db->authenticateUser($username, $password);

			if ($user) {
				$_SESSION['user'] = $user;
				redirect_back();
				die();

			}
			$password_is_valid = false;

		}
		include 'views/account/login.php';
	}

	public function logout(): void
	{
		unset($_SESSION['user']);
		redirect_back();
		die();
	}

	public function signup(): void
	{
		$signup_success = true; //assumed true for first run

		if (array_key_exists('user',$_SESSION)) {
			// User already logged in
			header("Location: /index.php");
			die();
		}

		if (isset($_POST['submitsignup'])) {
			$password = filter_input(INPUT_POST, 'password');
			$username = filter_input(INPUT_POST, 'username');
			$email = filter_input(INPUT_POST, 'email');

			// Will return a status true or false, if false contains errors array
			$userCreation = $this->db->createUser($username, $password, $email);

			// redirect to login page and display success message
			if ($userCreation["status"] == true) {
				header("Location: /account?action=login&status=accountCreated");
				// $_SESSION['user'] = $user;
				die();
			}
			// If this far, there was an error somehow, 
			$signup_success = false;
		}
		include 'views/account/signup.php';
	}
}