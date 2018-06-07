<?php


namespace App\Controller;

include_once('app/Model/Users.php');
include_once('app/Model/Hearts.php');

Use App\Model\Users as Users;
Use App\Model\Hearts as Hearts;

class HomeController
{
    /**
     *
     */
    private $user_db;
    private $hearts_db;
    private $pagePath = '/';

    public function __construct(Users $user_db, Hearts $hearts_db) {
    	$this->user_db = $user_db;
    	$this->hearts_db = $hearts_db;
    }

    function home_page()
    {
    	if (array_key_exists('user',$_SESSION)) {
    		$user = $this->getUserData($_SESSION["user"]);
    	}
        $page_path = $this->pagePath;
        include "views/home.php";
    }

    public function getUserData($userSession) {
    	$user = $this->user_db->getUser($userSession["username"]);

    	$user["userhearts"] = $this->hearts_db->getHeartsByUserId($user["id"]);
    	return $user;
    }
}