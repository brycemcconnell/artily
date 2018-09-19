<?php


namespace App\Controller;

Use App\Model\Users as Users;
Use App\Model\Hearts as Hearts;

class AccountController extends BaseController
{

	public function __construct(\PDO $pdo)
	{
		parent::__construct($pdo);
	}

	public function index(): void
	{
		$this->showAccount();
	}

	private function showAccount(): void
	{
		if (array_key_exists('user',$_SESSION) == false) {
			http_response_code(403);
			header("Location: /error?code=403");
			die();
		}
		include 'views/account/index.php';
	}

	public function processLogin(): void
	{
		$password_is_valid = true; //assumed true for first run

		if (isset($_POST['submitLogin'])) {
			$password = filter_input(INPUT_POST, 'password');
			$username = filter_input(INPUT_POST, 'username');
			$user = $this->users_db->authenticateUser($username, $password);

			// Login was correct
			if ($user) {
				// Set the session
				$_SESSION['user'] = $user;
				// Return to the page you came from
				redirect_back();
				die();

			}
			$password_is_valid = false;
			if (isset($_POST["redirect"])) {
				header("Location: /login?redirect=".$_POST["redirect"]);
			} else {
				header("Location: /login");
			}
			die();
		}
	}

	public function renderLogin(): void
	{
		// If already logged in, just redirect to last page, you can't login again
		if (array_key_exists('user',$_SESSION)) {
			redirect_back();
			die();
		}

		// Otherwise render the login page
		include 'views/account/login.php';
	}

	public function logout(): void
	{
		unset($_SESSION['user']);
		redirect_back();
		die();
	}

	public function processSignup(): void
	{
		$signup_success = true; //assumed true for first run

		
		if (isset($_POST['submitsignup'])) {
			$password = filter_input(INPUT_POST, 'password');
			$username = filter_input(INPUT_POST, 'username');
			$email = filter_input(INPUT_POST, 'email');
			
			// Will return a status true or false, if false contains errors array
			$userCreation = $this->users_db->createUser($username, $password, $email);
			// redirect to login page and display success message
			if ($userCreation["status"] == true) {
				if (isset($_POST["redirect"])) {
					header("Location: /login?redirect=".$_POST["redirect"]."&status=accountCreated");
				} else {
					header("Location: /login?status=accountCreated");
				}
				die();
			}
			
			// If this far, there was an error somehow, 
			$signup_success = false;
			if (isset($_POST["redirect"])) {
				header("Location: /signup?redirect=".$_POST["redirect"]);
			} else {
				header("Location: /signup");
			}
			die();
		}
	}

	public function renderSignup(): void
	{
		if (array_key_exists('user',$_SESSION)) {
			redirect_back();
			die();
		}
		var_dump("2");
		include 'views/account/signup.php';
	}

	
}