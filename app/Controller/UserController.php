<?php


namespace App\Controller;

include_once('app/Model/Users.php');
include_once('app/Model/Hearts.php');
include_once('app/Model/Posts.php');

Use App\Model\Users as Users;
Use App\Model\Hearts as Hearts;
Use App\Model\Posts as Posts;
use App\Utils\MYREQ as MYREQ;

class UserController
{
    /**
     *
     */
    private $user_db;
    private $hearts_db;
    private $posts_db;

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
        }
        echo "no action was defined";
        // No action defined
    }

    public function renderUserPage($user) {
        
    }

    public function getUserData($userSession) {
        $user = $this->users_db->getUser($userSession["username"]);

        $user["userhearts"] = $this->hearts_db->getHeartsByUserId($user["id"]);
        return $user;
    }
}