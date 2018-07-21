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
include_once "app/Controller/UserController.php";

use App\Controller\HomeController as HomeController;
use App\Controller\AccountController as AccountController;
use App\Controller\ErrorController as ErrorController;
use App\Controller\PostController as PostController;
use App\Controller\UserController as UserController;

include_once "app/Model/Users.php";
include_once "app/Model/Hearts.php";
include_once "app/Model/Posts.php";
include_once "app/Model/Comments.php";

include_once "app/Core/Router.php";
include_once 'app/Core/Request.php';
use App\Core\Router as Router;
use App\Core\Request as Request;


/******************************************************************

Home

******************************************************************/
Router::get('index.php', '', function($db) {
    // Controller = HomeController
    // Method = default (read)
    $Controller = new HomeController($db->pdo);
    $Controller->index();
});
Router::get('index.php', 'view', function($db) {
    // Controller = HomeController
    // Method = view (new|trending|all)
    $Controller = new HomeController($db->pdo);
    $Controller->index(Request::$query);
});

/******************************************************************

Errors

******************************************************************/
Router::get('error', 'code', function() {
    // Controller = ErrorController
    // Method = display {code}
});

/******************************************************************

Users 

******************************************************************/
Router::get('users', '', function() {
    // Controller = UserController
    // Method = default (read)
});
Router::get('users/{id}', '', function() {
    // Controller = UserController
    // Method = default (read) :id
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
Router::get('boards', '', function() {
    // Controller = BoardController
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
Router::get('boards/{id}', '', function() {
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
    // Controller = BoardController
    // Method = action (new)
});
Router::post('boards/{id}/posts', 'action', function() {
    // Controller = BoardController
    // Method = action (new)
});

/******************************************************************

(boards)/posts

******************************************************************/
Router::get('boards/{id}/posts/{id}', '', function() {
    // Controller = PostController
    // Method = default (read)
});
Router::get('boards/{id}/posts/{id}', 'sort', function() {
    // Controller = PostController
    // Method = sort (new|old|trending|top_comments|top_hearts)
    // Note: this is sorting the comments on the post
});
Router::get('boards/{id}/posts/{id}', 'action', function() {
    // Controller = PostController
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
Router::get('account', '', function() {
    // Controller = AccountController
    // Method = default (read)
    // Note: This should show some account details, eg: email, created,
    // username, and edit/delete account buttons
});
Router::get('account', 'action', function() {
    // Controller = AccountController
    // Method = action (login|logout|signup|edit|delete)
});
Router::post('account', 'action', function() {
    // Controller = AccountController
    // Method = action (login|logout|signup|edit|delete)
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
if (Router::$routeFound === false) {
    // header("Location: /error?code=404");
    
    Request::print_debug("No route was found");
    die();
}
