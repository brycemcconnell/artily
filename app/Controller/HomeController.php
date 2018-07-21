<?php

namespace App\Controller;

Use App\Model\Users as Users;
Use App\Model\Hearts as Hearts;
Use App\Model\Posts as Posts;

Use App\Core\Request as Request;

Use PDO;

class HomeController
{
    private $user_db;
    private $hearts_db;
    private $posts_db;

    private $user;

    public function __construct(\PDO $pdo)
    {
    	$this->user_db = new Users($pdo);
        $this->hearts_db = new Hearts($pdo);
    	$this->posts_db = new Posts($pdo);

        if (array_key_exists('user',$_SESSION)) {
            $this->user = $this->getUserData($_SESSION["user"]);
        }
    }

    public function index($query = ["view" => "home"]): void
    {
        $view = $query["view"] ?? null;
        switch ($view) {
            case 'all':
                $this->renderLatest();
            break;
            case 'trending':
                $this->renderTrending();
            break;
            case 'home':
                $this->renderHome();
            break;
            default:
                header("Location: /error?code=404");
            break;
        }
    }

    private function renderHome()
    {
        $posts = $this->posts_db->getPostsLatest();
        include Request::$api."/home/home.php";
    }

    private function renderLatest()
    {
        $posts = $this->posts_db->getPostsLatest();
        include Request::$api."/home/home.php";
    }

    private function renderTrending()
    {
        $posts = $this->posts_db->getPostsTrending();
        include Request::$api."/home/home.php";
    }

    public function getUserData($userSession) {
    	$user = $this->user_db->getUser($userSession["username"]);

    	$user["userhearts"] = $this->hearts_db->getHeartsByUserId($user["id"]);
    	return $user;
    }
}