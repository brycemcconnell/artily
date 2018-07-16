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
include_once "app/Controller/PostController.php";
include_once "app/Controller/CommentController.php";

use App\Controller\HomeController as HomeController;
use App\Controller\AccountController as AccountController;
use App\Controller\ErrorController as ErrorController;
use App\Controller\PostController as PostController;
use App\Controller\CommentController as CommentController;
// use App\Controller\ArtboardController as ArtboardController;


use App\Model\Users as Users;
$user_db = new Users($pdo);
use App\Model\Hearts as Hearts;
$hearts_db = new Hearts($pdo);
use App\Model\Posts as Posts;
$posts_db = new Posts($pdo);
use App\Model\Comments as Comments;
$comments_db = new Comments($pdo);

// create controllers
$HomeController = new HomeController($user_db, $hearts_db, $posts_db);
$AccountController = new AccountController($user_db);
$ErrorController = new ErrorController();
$PostController = new PostController($posts_db, $user_db, $hearts_db, $comments_db);
$CommentController = new CommentController($user_db, $comments_db);
// $ArtboardController = new ArtboardController();

// $action = $_GET['action'] ?? '';

include_once "app/Router.php";
use App\Router as Router;
use App\Utils\MYREQ as MYREQ;

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
// Router::set('artboard', function() {
//     global $ArtboardController;
//     $ArtboardController->run();
// });
Router::set('post', function() {
    global $PostController;
    $PostController->run();
});
// Router::set('comment', function() {
//     global $CommentController;
//     $CommentController->run();
// });
/*
Router::set('api', function() {
    global $APIController;
    $APIController->run();
});
*/


if (Router::$routeFound === false) {
    // header("Location: /error?code=404");
    
    MYREQ::print_debug("No route was found");
    die();
}
