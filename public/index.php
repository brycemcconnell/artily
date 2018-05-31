<?php
/*
*  index page responds to user actions
*  routes to the corresponding method
*  in BookingsController. 
*  No Action = load home page
 */

error_reporting(E_ALL);
ini_set('display_errors', 1);

include_once '../config.php';

include_once "app/Controller/HomeController.php";
include_once "app/Controller/LoginController.php";

use App\Controller\HomeController as HomeController;
use App\Controller\LoginController as LoginController;


use App\Model\Users as Users;
$user_db = new Users($pdo);

// create controllers
$homeController = new HomeController();
$loginController = new LoginController($user_db);


$action = $_GET['action'] ?? '';

switch ($action) {
	case 'login':
		if (array_key_exists('user', $_SESSION)) {
            header("Location: /index.php");
            die();
        }
        $loginController->login();
		break;
	case 'logout':
		if (!array_key_exists('user', $_SESSION)) {
            header("Location: /index.php?action=login");
            die();
        }
        $loginController->logout();
		break;
    default:
        $homeController->home_page();
        break;
}
