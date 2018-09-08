<?php


namespace App\Controller;

Use App\Model\Users as Users;
Use App\Model\Hearts as Hearts;
Use App\Model\Posts as Posts;
Use App\Model\Comments as Comments;
use App\Core\Request as Request;

use \DateTime;
use \DateTimeZone;


class CommentController
{
    /**
     *
     */
    private $posts_db;
    private $users_db;
    private $hearts_db;
    private $comments_db;
    
    private $user;

    public function __construct(\PDO $pdo)
    {
        // parent::__construct($pdo);
    	$this->posts_db = new Posts($pdo);
        $this->users_db = new Users($pdo);
        $this->hearts_db = new Hearts($pdo);
        $this->comments_db = new Comments($pdo);

        if (array_key_exists('user',$_SESSION)) {
            $this->user = $this->getUserData($_SESSION["user"]);
        }
    }
    /**
     * Description
     * @param [type] $query - Suppose the query is the read action in CRUD
     * @return void
     */
    public function index($query)
    {
        // If an comment id is present, show that comment info page with
        // 1. Original post at top, 2. nested comments below
        // In order to see all comments remove the query
        $this->viewBoard($query);

        // There was no comment id, show all comments in the thread and the OP
        $this->board_index();
    }

    public function action($query)
    {  
        // If a board is present, handle it's actions

        // Otherwise handle index actions (eg. creating new board)

    }

    public function sort($query)
    {
        // Sort the order of board index

    }

    private function viewBoard($query)
    {
        // If query is int
        $this->boards_db->getBoardById($query);
        // If query is string
        $this->boards_db->getBoardByName($query);
    }
}