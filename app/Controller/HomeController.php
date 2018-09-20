<?php

namespace App\Controller;

Use App\Model\Posts as Posts;

Use App\Core\Request as Request;

use App\Controller\BaseController as BaseController;

Use PDO;

class HomeController extends BaseController
{
    private $posts_db;

    public function __construct(\PDO $pdo)
    {
    	parent::__construct($pdo);
    	$this->posts_db = new Posts($pdo);
    }

    public function index($query = ["sort" => "home"]): void
    {
        $sort = $query["sort"] ?? null;
        switch ($sort) {
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
        $page_count = $this->posts_db->countPosts();

        $page = 0;
        if (isset($_GET["page"])) {
            $page = $_GET["page"];
        }
        if (isset($_SESSION["user"])) {
            $posts = $this->posts_db->user_getPostsLatest($page, $_SESSION["user"]["id"]);
        } else {
            $posts = $this->posts_db->getPostsLatest($page);
        }
        include "views/home/home_index.php";
    }

    private function renderLatest()
    {
        $posts = $this->posts_db->getPostsLatest();
        include "views/home/home_index.php";
    }

    private function renderTrending()
    {
        $posts = $this->posts_db->getPostsTrending();
        include "views/home/home_index.php";
    }
}