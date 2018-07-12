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
include_once "app/Controller/ErrorController.php";

use App\Controller\HomeController as HomeController;
use App\Controller\AccountController as AccountController;
use App\Controller\ErrorController as ErrorController;


use App\Model\Users as Users;
$user_db = new Users($pdo);
use App\Model\Hearts as Hearts;
$hearts_db = new Hearts($pdo);

// create controllers
$HomeController = new HomeController($user_db, $hearts_db);
$AccountController = new AccountController($user_db);
$ErrorController = new ErrorController();

// $action = $_GET['action'] ?? '';

include_once "app/Router.php";
use App\Router as Router;

Router::set('index.php', function() {
    global $HomeController;
    $HomeController->run();
});
Router::set('account', function() {
    global $AccountController;
    $AccountController->run();
});
Router::set('error', function() {
    global $ErrorController;
    $ErrorController->run();
});
/*
Router::set('api', function() {
    global $APIController;
    $APIController->run();
});
*/
if (Router::$routeFound === false) {
    header("Location: /error?code=404");
    die();
}

/*

switch ($route) {
    case '/':
    case 'home':
        $HomeController->home_page();
    break;
    case 'login':

    break;
    case 'signup':

    break;
    default:
        header("HTTP/1.0 404 Not Found");
        $HomeController->home_page();
    break;
}
*/
/*
switch ($action) {
	case 'login':
		if (array_key_exists('user', $_SESSION)) {
            header("Location: /index.php");
            die();
        }
        $LoginController->login();
		break;
	case 'logout':
        if (!array_key_exists('user', $_SESSION)) {
            header("Location: /index.php?action=login");
            die();
        }
        $LoginController->logout();
        break;
    case 'signup':
		if (array_key_exists('user', $_SESSION)) {
            header("Location: /index.php");
            die();
        }
        $SignupController->signup();
		break;
    default:
        $HomeController->home_page();
        break;
}
*/