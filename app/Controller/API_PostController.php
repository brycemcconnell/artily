<?php


namespace App\Controller;

Use App\Model\Users as Users;
Use App\Model\Hearts as Hearts;
Use App\Model\Posts as Posts;
Use App\Model\Comments as Comments;
use App\Core\Request as Request;

use \DateTime;
use \DateTimeZone;


class API_PostController
{
    /**
     *
     */
    private $posts_db;
    private $users_db;
    private $hearts_db;
    private $comments_db;

    public function __construct(\PDO $pdo)
    {
        $this->posts_db = new Posts($pdo);
        $this->users_db = new Users($pdo);
        $this->hearts_db = new Hearts($pdo);
        $this->comments_db = new Comments($pdo);
    }

    public function addHeart(int $user_id, int $post_id)
    {
        $success = $this->hearts_db->addPostHeart($user_id, $post_id);

        if ($success) {
            return 'Success';
        } else {
            return false;
        }
    }

    public function removeHeart(int $user_id, int $post_id)
    {
        $success = $this->hearts_db->removePostHeart($user_id, $post_id);

        if ($success) {
            return 'Success';
        } else {
            return false;
        }
    }
}