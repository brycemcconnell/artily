<?php


namespace App\Controller;

include_once('app/Model/Users.php');
include_once('app/Model/Hearts.php');
include_once('app/Model/Posts.php');

Use App\Model\Users as Users;
Use App\Model\Hearts as Hearts;
Use App\Model\Posts as Posts;

class HomeController
{
    /**
     *
     */
    private $user_db;
    private $hearts_db;
    private $posts_db;

    private $user;

    private $pagePath = '/';

    public function __construct(Users $user_db, Hearts $hearts_db, Posts $posts_db) {

    	$this->user_db = $user_db;
        $this->hearts_db = $hearts_db;
    	$this->posts_db = $posts_db;

    }

    function run() {
        if (array_key_exists('user',$_SESSION)) {
            $this->user = $this->getUserData($_SESSION["user"]);
        }
        if (isset($_GET["action"])) {
            switch ($_GET["action"]) {
                default:
                    header("Location: /error?code=404");
                    die();
                break;
            }
        } else if (isset($_GET["view"])) {
            switch ($_GET["view"]) {
                case "home":
                    $this->renderHome();
                break;
                case "trending":
                    $this->renderTrending();
                break;
                case "all":
                    $this->renderAll();
                break;
            }
        } else {
            $this->renderHome();
        }
    }

    function renderHome()
    {
        if (array_key_exists('user',$_SESSION)) {
            $user = $this->getUserData($_SESSION["user"]);
        }
        $page_path = $this->pagePath;
        $posts = $this->posts_db->getPostsLatest();
        // $posts = $this->posts_db->getPostsTrending();
        include "views/home/home.php";
    }

    function renderTrending()
    {
        if (array_key_exists('user',$_SESSION)) {
            $user = $this->getUserData($_SESSION["user"]);
        }
        $page_path = $this->pagePath;
        $posts = $this->posts_db->getPostsTrending();
        include "views/home/home.php";
    }

    function renderAll()
    {
    	if (array_key_exists('user',$_SESSION)) {
    		$user = $this->getUserData($_SESSION["user"]);
    	}
        $page_path = $this->pagePath;
        $posts = $this->posts_db->getPostsLatest();
        // $posts = $this->posts_db->getPostsTrending();
        include "views/home/home.php";
    }

    public function getUserData($userSession) {
    	$user = $this->user_db->getUser($userSession["username"]);

    	$user["userhearts"] = $this->hearts_db->getHeartsByUserId($user["id"]);
    	return $user;
    }
}