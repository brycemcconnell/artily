<?php


namespace App\Controller;

Use App\Model\Posts as Posts;
use App\Core\Request as Request;

class UserController extends BaseController
{
    /**
     *
     */

    private $posts_db;

    public function __construct(\PDO $pdo)
    {
        parent::__construct($pdo);
        $this->posts_db = new Posts($pdo);
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

    public function renderMe()
    {
        if (isset($_SESSION["user"]) == false) {
            http_response_code(403);
            header("Location: /error?code=403");
            die();
        }

        $user = $this->users_db->getUserById($_SESSION["user"]["id"]);

        $posts = $this->posts_db->getPostsByUserId($_SESSION["user"]["id"]);

        include "views/users/view_user.php";
    }

    public function renderUserById(int $user_id)
    {
        $user = $this->users_db->getUserById($user_id);

        $posts = $this->posts_db->getPostsByUserId($user_id);

        include "views/users/view_user.php";
    }

    public function renderUserByName(string $username)
    {
        $user = $this->users_db->getUserByName($username);

        $posts = $this->posts_db->getPostsByUserId($user["id"]);

        include "views/users/view_user.php";
    }
        

    public function getUserData($userSession) {
        $user = $this->users_db->getUser($userSession["username"]);

        $user["userhearts"] = $this->hearts_db->getHeartsByUserId($user["id"]);
        return $user;
    }
}