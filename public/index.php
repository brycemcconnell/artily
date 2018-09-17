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

include_once "app/Controller/BaseController.php";
include_once "app/Controller/HomeController.php";
include_once "app/Controller/AccountController.php";
include_once "app/Controller/ErrorController.php";
include_once "app/Controller/PostController.php";
include_once "app/Controller/API_PostController.php";
include_once "app/Controller/UserController.php";
include_once "app/Controller/BoardController.php";


use App\Controller\HomeController as HomeController;
use App\Controller\AccountController as AccountController;
use App\Controller\ErrorController as ErrorController;
use App\Controller\PostController as PostController;
use App\Controller\API_PostController as API_PostController;
use App\Controller\UserController as UserController;
use App\Controller\BoardController as BoardController;


include_once "app/Model/Users.php";
include_once "app/Model/Hearts.php";
include_once "app/Model/Posts.php";
include_once "app/Model/Comments.php";
include_once "app/Model/Boards.php";

include_once "app/Core/Router.php";
include_once 'app/Core/Request.php';
use App\Core\Router as Router;
use App\Core\Request as Request;


Router::get('api/authenticate', '', function() {
    header('Content-Type: application/json');
    if (isset($_SESSION["user"])) {
        //
        echo json_encode("Logged in as ".$_SESSION["user"]["username"]);
    } else {
        echo json_encode("You're not logged in");
    }
});

Router::post('api/posts/addheart', '', function($db) {
    $_POST = json_decode(file_get_contents('php://input'), true);
    if (isset($_SESSION["user"]) && isset($_POST["post_id"])) {
        $user_id = $_SESSION["user"]["id"];
        $post_id = $_POST["post_id"];
        $Controller = new API_PostController($db->pdo);
        $result = $Controller->addHeart($user_id, $post_id);
        if ($result) {
            header('Content-Type: application/json');
            echo json_encode([
                "status" => "Successfully added heart",
                "user_id" => $user_id,
                "post_id" => $post_id
            ]);
        } else {
            header($_SERVER["SERVER_PROTOCOL"]." 500 Internal Server Error");
            echo json_encode("There was an sql error");
        }
    } else {
        header($_SERVER["SERVER_PROTOCOL"]." 401 Unauthorized");
        echo json_encode("You're not logged in");
    }
});

Router::post('api/posts/removeheart', '', function($db) {
    $_POST = json_decode(file_get_contents('php://input'), true);
    if (isset($_SESSION["user"]) && isset($_POST["post_id"])) {
        $user_id = $_SESSION["user"]["id"];
        $post_id = $_POST["post_id"];
        $Controller = new API_PostController($db->pdo);
        $result = $Controller->removeHeart($user_id, $post_id);
        if ($result) {
            header('Content-Type: application/json');
            echo json_encode([
                "status" => "Successfully removed heart",
                "user_id" => $user_id,
                "post_id" => $post_id
            ]);
        } else {
            header($_SERVER["SERVER_PROTOCOL"]." 500 Internal Server Error");
            echo json_encode("There was an sql error");
        }
    } else {
        header($_SERVER["SERVER_PROTOCOL"]." 401 Unauthorized");
        echo json_encode("You're not logged in");
    }
});

/******************************************************************

Home

******************************************************************/
Router::get('', '', function($db) {
    $Controller = new HomeController($db->pdo);
    // Display the index page
    $Controller->index();
});
Router::get('', 'sort', function($db) {
    $Controller = new HomeController($db->pdo);
    // Display the index page with a type of sort
    $Controller->index(Request::$query);
});

/******************************************************************

Errors

******************************************************************/
Router::get('error', 'code', function() {
    $Controller = new ErrorController(Request::$query);
    // Display the error page
    $Controller->render();
});

/******************************************************************

Users 

******************************************************************/
Router::get('me', '', function($db) {
    $Controller = new UserController($db->pdo);
    $Controller->renderMe();
});
Router::get('users', '', function($db) {
    $Controller = new UserController($db->pdo);
    $Controller->index();
});
Router::get('users/{user_name}', '', function($db) {
    $Controller = new UserController($db->pdo);
    $Controller->renderUserByName(Router::$items["user_name"]);
});
Router::get('users/{id}/collections', '', function() {
    // Controller = UserController
    // Method = default (read) :id collections
});
Router::get('users/{id}/boards', '', function() {
    // Controller = UserController
    // Method = default (read) :id boards
});
Router::get('users/{id}/comments', '', function() {
    // Controller = UserController
    // Method = default (read) :id comments
});
Router::get('users/{id}/posts', '', function() {
    // Controller = UserController
    // Method = default (read) :id posts
});

/******************************************************************

Boards

******************************************************************/
Router::get('boards', '', function($db) {
    // Controller = BoardController
    $Controller = new BoardController($db->pdo);
    $Controller->index();
    // Method = default (read)
});
Router::get('boards', 'action', function() {
    // Controller = BoardController
    // Method = action (new)
});
Router::post('boards', 'action', function() {
    // Controller = BoardController
    // Method = action (new)
});
Router::get('boards', 'sort', function() {
    // Controller = BoardController
    // Method = sort (new|old|trending|top)
});
Router::get('boards/{board_id}', '', function($db) {
    $Controller = new BoardController($db->pdo);
    $Controller->render(Router::$items["board_id"]);
    // Controller = BoardController
    // Method = default (read)
    // Show 
});
Router::get('boards/{id}', 'action', function() {
    // Controller = BoardController
    // Method = action (delete|edit)
});
Router::post('boards/{id}', 'action', function() {
    // Controller = BoardController
    // Method = default (delete|edit)
});
Router::get('boards/{id}/posts', '', function() {
    // Controller = BoardController
    // Method = default (read)
});
Router::get('boards/{id}/posts', 'sort', function() {
    // Controller = BoardController
    // Method = sort (new|old|trending|top_comments|top_hearts)
    // Note: this is sorting the posts on a board
});
Router::get('boards/{id}/posts', 'action', function() {
    
    // Controller = BoardController/PostController?
    // Method = action (new)
});
Router::post('boards/{id}/posts', 'action', function() {

    // Controller = BoardController/PostController?
    // Method = action (new)
});

/******************************************************************

/posts

******************************************************************/
Router::get('new_post', '', function($db) {
    $Controller = new PostController($db->pdo);
    $Controller->renderNewPost();
});

Router::post('new_post', '', function($db) {
    $Controller = new PostController($db->pdo);
    $Controller->submitNewPost();
});
Router::get('posts', 'action', function() {
    // Give an option to input a board name
    // Maybe this should be a different controller? eh..
    // Controller = BoardController/PostController?
    // Method = action (new)
});

Router::post('posts', 'action', function() {
    // Controller = BoardController/PostController?
    // Method = action (new)
});

/******************************************************************

(boards)/posts

******************************************************************/
Router::get('boards/{board_id}/posts/{post_id}', '', function($db) {
    $Controller = new PostController($db->pdo);
    // Method = default (read)
    // var_dump(Router::$items);
    $Controller->render(Router::$items["post_id"]);
    // Controller = PostController
    // Method = default (read)
});
Router::get('boards/{id}/posts/{id}', 'sort', function() {
    // Controller = PostController
    // Method = sort (new|old|trending|top_comments|top_hearts)
    // Note: this is sorting the comments on the post
});
Router::get('boards/{id}/posts/{id}', 'action', function() {
    $Controller = new PostController($db->pdo);
    // Controller = PostController
    $Controller->action(Request::$query);
    // Method = action (reply|edit|delete)
    // Note: the reply action may also have a second query 'comment',
    // this should be handled inside the controller
});
Router::post('boards/{id}/posts/{id}', 'action', function() {
    // Controller = PostController
    // Method = action (reply|edit|delete)
    // Note: the reply action may also have a second query 'comment',
    // this should be handled inside the controller
});

/******************************************************************

Collections

******************************************************************/
Router::get('collections', '', function() {
    // Controller = CollectionController
    // Method = default (read)
});
Router::get('collections', 'sort', function() {
    // Controller = CollectionController
    // Method = sort (new|old|trending|top_comments|top_hearts)
});
Router::get('collections', 'action', function() {
    // Controller = CollectionController
    // Method = action (new)
});
Router::post('collections', 'action', function() {
    // Controller = CollectionController
    // Method = action (new)
});
Router::get('collections/{id}', '', function() {
    // Controller = CollectionController
    // Method = default (read)
    // Note: a collection can only be sorted by the owner
    // through the edit action?
});
Router::get('collections/{id}', 'action', function() {
    // Controller = CollectionController
    // Method = action (edit|delete)
});
Router::post('collections/{id}', 'action', function() {
    // Controller = CollectionController
    // Method = action (edit|delete)
});

/******************************************************************

Accounts

******************************************************************/
Router::get('account', '', function($db) {
    // Controller = AccountController
    $Controller = new AccountController($db->pdo);
    // Method = default (read)
    $Controller->index();
    // Note: This should show some account details, eg: email, created,
    // username, and edit/delete account buttons
});
Router::get('login', '', function($db) {
    // Controller = AccountController
    $Controller = new AccountController($db->pdo);
    // Method = action (login|logout|signup|edit|delete)
    $Controller->renderLogin();
});
Router::post('login', '', function($db) {
    // Controller = AccountController
    $Controller = new AccountController($db->pdo);
    // Method = action (login|logout|signup|edit|delete)
    $Controller->processLogin();
});
Router::get('logout', '', function($db) {
    // Controller = AccountController
    $Controller = new AccountController($db->pdo);
    // Method = action (login|logout|signup|edit|delete)
    $Controller->logout();
});
Router::get('signup', '', function($db) {
    // Controller = AccountController
    $Controller = new AccountController($db->pdo);
    // Method = action (login|logout|signup|edit|delete)
    $Controller->renderSignup();
});
Router::post('signup', '', function($db) {
    // Controller = AccountController
    $Controller = new AccountController($db->pdo);
    // Method = action (login|logout|signup|edit|delete)
    $Controller->processSignup();
});

/******************************************************************

Reports

******************************************************************/
Router::get('reports', '', function() {
    // Controller = ReportController
    // Method = default (read)
    // Note: Show the status of user's submitted reports
});
Router::get('reports', 'action', function() {
    // Controller = ReportController
    // Method = action (new)
    // Note: this will contain subqueries type and id for the controller to handle
});
Router::post('reports', 'action', function() {
    // Controller = ReportController
    // Method = action (new)
});

/******************************************************************

Messages

******************************************************************/
Router::get('messages', '', function() {
    // Controller = MessageController
    // Method = default (read)
});
Router::get('messages', 'sort', function() {
    // Controller = MessageController
    // Method = sort (read|unread|new|old)
});
Router::get('messages', 'action', function() {
    // Controller = MessageController
    // Method = action (new)
});
Router::post('messages', 'action', function() {
    // Controller = MessageController
    // Method = action (new)
});
Router::get('messages/{id}', '', function() {
    // Controller = MessageController
    // Method = default (read)
});
Router::get('messages/{id}', 'action', function() {
    // Controller = MessageController
    // Method = action (delete)
});
Router::post('messages/{id}', 'action', function() {
    // Controller = MessageController
    // Method = action (delete)
});

/******************************************************************

Debug

******************************************************************/
// header("Location: /error?code=404");
Request::print_debug("No route was found");
