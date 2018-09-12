<?php


namespace App\Controller;


use App\Core\Request as Request;

class UserController extends BaseController
{
    /**
     *
     */

    public function __construct(\PDO $pdo)
    {
        parent::__construct($pdo);
    }

    public function index()
    {
        $users = $this->users_db->getUsers();

        include "views/users/user_index.php";
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