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

    private $pagePath = '/';

    public function __construct(Users $user_db, Hearts $hearts_db, Posts $posts_db) {

    	$this->user_db = $user_db;
        $this->hearts_db = $hearts_db;
    	$this->posts_db = $posts_db;

    }

    function run() {
        if (isset($_GET["action"])) {
            switch ($_GET["action"]) {
                default:
                    header("Location: /error?code=404");
                    die();
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
        include "views/home/home.php";
    }

    public function getUserData($userSession) {
    	$user = $this->user_db->getUser($userSession["username"]);

    	$user["userhearts"] = $this->hearts_db->getHeartsByUserId($user["id"]);
    	return $user;
    }
}