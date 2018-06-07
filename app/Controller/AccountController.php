<?php


namespace App\Controller;

include_once('app/Model/Users.php');

Use App\Model\Users as Users;

class AccountController {
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

    public function signup(): void
    {
        $signup_success = true; //assumed true for first run

        if (array_key_exists('user',$_SESSION)) {
            // header("Location: /index.php");
            var_dump("youre logged in");
            die();
        }

        if (isset($_POST['submitsignup'])) {
            $password = filter_input(INPUT_POST, 'password');
            $username = filter_input(INPUT_POST, 'username');
            $email = filter_input(INPUT_POST, 'email');
            $user = $this->db->createUser($username, $password, $email);

            if ($user) {
                var_dump($user);
                $_SESSION['user'] = $user;
                // header("Location: /index.php");
                die();

            }
            $signup_success = false;

        }
        include 'views/signup.php';
    }
}