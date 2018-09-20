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

  public function __construct(\PDO $pdo)
  {
      parent::__construct($pdo);
  }

  public function index()
  {
    $notification_count = $this->notifications_db->user_getNotificationCount($_SESSION["user"]["id"]);
    $notifications = $this->notifications_db->user_getNotifications($_SESSION["user"]["id"]);
    include "views/notifications/notification_index.php";
  }
}