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

	public function action($query): void
	{
		$action = $query["action"] ?? null;
        switch ($action) {
            case 'login':
                $this->login();
            break;
            case 'logout':
                $this->logout();
            break;
            case 'signup':
                $this->signup();
            break;
            default:
                header("Location: /error?code=404");
            break;
        }
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

	private function login(): void
	{
		$password_is_valid = true; //assumed true for first run

		if (array_key_exists('user',$_SESSION)) {
			redirect_back();
			die();
		}

		if (isset($_POST['submitLogin'])) {
			$password = filter_input(INPUT_POST, 'password');
			$username = filter_input(INPUT_POST, 'username');
			$user = $this->users_db->authenticateUser($username, $password);

			if ($user) {
				$_SESSION['user'] = $user;
				redirect_back();
				die();

			}
			$password_is_valid = false;

		}
		include 'views/account/login.php';
	}

	private function logout(): void
	{
		unset($_SESSION['user']);
		redirect_back();
		die();
	}

	private function signup(): void
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
			$userCreation = $this->users_db->createUser($username, $password, $email);

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