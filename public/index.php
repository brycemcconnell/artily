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
include_once "app/Controller/AccountController.php";

use App\Controller\HomeController as HomeController;
use App\Controller\AccountController as AccountController;


use App\Model\Users as Users;
$user_db = new Users($pdo);
use App\Model\Hearts as Hearts;
$hearts_db = new Hearts($pdo);

// create controllers
$homeController = new HomeController($user_db, $hearts_db);
$AccountController = new AccountController($user_db);


$action = $_GET['action'] ?? '';

switch ($action) {
	case 'login':
		if (array_key_exists('user', $_SESSION)) {
            header("Location: /index.php");
            die();
        }
        $AccountController->login();
		break;
	case 'logout':
        if (!array_key_exists('user', $_SESSION)) {
            header("Location: /index.php?action=login");
            die();
        }
        $AccountController->logout();
        break;
    case 'signup':
		if (array_key_exists('user', $_SESSION)) {
            header("Location: /index.php");
            die();
        }
        $AccountController->signup();
		break;
    default:
        $homeController->home_page();
        break;
}
