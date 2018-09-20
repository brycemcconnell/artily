<?php


namespace App\Controller;

// Use App\Model\Posts as Posts;
// Use App\Model\Comments as Comments;
Use App\Model\Notifications as Notifications;
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
  private $notifications_db;

  public function __construct(\PDO $pdo)
  {
      parent::__construct($pdo);
      $this->notifications_db = new Notifications($pdo);
      // $this->comments_db = new Comments($pdo);
  }

  public function index()
  {
    $notification_count = $this->notifications_db->user_getNotificationCount($_SESSION["user"]["id"]);
    $notifications = $this->notifications_db->user_getNotifications($_SESSION["user"]["id"]);
    include "views/notifications/notification_index.php";
  }
}