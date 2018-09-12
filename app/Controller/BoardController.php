<?php


namespace App\Controller;

Use App\Model\Posts as Posts;
Use App\Model\Comments as Comments;
use App\Core\Request as Request;

use App\Controller\BaseController as BaseController;

use \DateTime;
use \DateTimeZone;


class BoardController extends BaseController
{
    /**
     *
     */
    private $comments_db;

    public function __construct(\PDO $pdo)
    {
        parent::__construct($pdo);
        $this->comments_db = new Comments($pdo);
    }

    public function index()
    {
        // Show list of all boards
        $boards = $this->boards_db->getBoards();
        
        include "views/boards/board_index.php";
    }

    public function render(string $board_name)
    {
        $board_data = $this->boards_db->getBoardByName($board_name);
        if (isset($_SESSION["user"])) {
            $board_posts = $this->boards_db->userGetBoardPostsById($_SESSION["user"]["id"], $board_data["id"]);
        } else {
            $board_posts = $this->boards_db->getBoardPostsById($board_data["id"]);
        }
        
        include "views/boards/view_board.php";
    }

    public function sort($query)
    {
        // Sort the order of board index

    }

}