<?php


namespace App\Controller;

include_once('app/Model/Users.php');
include_once('app/Utils/Validation.php');

Use App\Model\Users as Users;
Use App\Utils\Validation as Validation;

class LoginController {
	private $db;

	public function __construct(Users $db) {
		$this->db = $db;
	}

	public function login(): void
    {
        $password_is_valid = true; //assumed true for first run

        if (array_key_exists('user',$_SESSION)) {
            header("Location: /index.php");
            die();
        }

        if (isset($_POST['submitLogin'])) {
            $password = filter_input(INPUT_POST, 'password');
            $username = filter_input(INPUT_POST, 'username');
            $user = $this->db->authenticateUser($username, $password);

            if ($user) {
                $_SESSION['user'] = $user;

                header("Location: /index.php");
                die();

            }
            $password_is_valid = false;

        }
        include 'views/login.php';
    }

    public function logout(): void
    {
        unset($_SESSION['user']);
        header("Location: /index.php?status=loggedout");
        die();
    }
}