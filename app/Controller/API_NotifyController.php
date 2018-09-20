<?php


namespace App\Controller;

Use App\Model\Users as Users;
Use App\Model\Hearts as Hearts;
Use App\Model\Posts as Posts;
Use App\Model\Comments as Comments;
Use App\Model\Notifications as Notifications;
use App\Core\Request as Request;

use \DateTime;
use \DateTimeZone;


class API_NotifyController
{
    /**
     *
     */
    private $posts_db;
    private $users_db;
    private $hearts_db;
    private $comments_db;
    private $notifications_db;

    public function __construct(\PDO $pdo)
    {
        $this->posts_db = new Posts($pdo);
        $this->users_db = new Users($pdo);
        $this->hearts_db = new Hearts($pdo);
        $this->comments_db = new Comments($pdo);
        $this->notifications_db = new Notifications($pdo);
    }

    public function notifyFrom(int $user_id)
    {
      $post = $this->posts_db->getPostById($_POST["trigger_id"]);

      $success = $this->notifications_db->sendFrom($user_id, $post["id"]);

      if ($success) {
          return 'Success';
      } else {
          return false;
      }
    }
}