<?php


namespace App\Controller;

Use App\Model\Users as Users;
Use App\Model\Hearts as Hearts;
Use App\Model\Posts as Posts;
Use App\Model\Comments as Comments;
use App\Core\Request as Request;

use \DateTime;
use \DateTimeZone;


class CommentController extends BaseController
{
    /**
     *
     */
    private $posts_db;
    private $comments_db;
    

    public function __construct(\PDO $pdo)
    {
        parent::__construct($pdo);
    	$this->posts_db = new Posts($pdo);
        $this->comments_db = new Comments($pdo);

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

    public function reply(string $post_name)
    {
        $original_post = $this->posts_db->getPostByTitle($post_name);
        $post_data = array();
        $post_data["post_id"] = $original_post["post_id"];
        $post_data["content"] = $_POST["content"] ?? '';
        $post_data["user_id"] = $_SESSION["user"]["id"];
        $post_data["parent_comment_id"] = NULL;
        $result = $this->comments_db->create_comment($post_data);

        if (isset($result))
            header("Location: ".$_POST["redirect"]);
            die();
    }
}