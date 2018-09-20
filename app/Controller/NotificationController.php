<?php


namespace App\Controller;

// Use App\Model\Posts as Posts;
// Use App\Model\Comments as Comments;
use App\Core\Request as Request;

use App\Controller\BaseController as BaseController;

use \DateTime;
use \DateTimeZone;


class NotificationController extends BaseController
{
  /**
   *
   */
  // private $comments_db;
  // private $posts_db;

  public function __construct(\PDO $pdo)
  {
      parent::__construct($pdo);
      // $this->posts_db = new Posts($pdo);
      // $this->comments_db = new Comments($pdo);
  }

  public function index()
  {
    include "views/notifications/notification_index.php";
  }
}