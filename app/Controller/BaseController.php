<?php


namespace App\Controller;

Use App\Model\Users as Users;
Use App\Model\Hearts as Hearts;
use App\Model\Boards as Boards;

class BaseController
{
	protected $users_db;
	protected $hearts_db;
	protected $boards_db;

  protected $user = [];
  protected $board_list;

  public function __construct(\PDO $pdo)
  {
		$this->users_db = new Users($pdo);
		$this->hearts_db = new Hearts($pdo);
		$this->boards_db = new Boards($pdo);

		if (array_key_exists('user',$_SESSION)) {
      // $this->user = $this->getUserData($_SESSION["user"]);
      $this->user["userhearts"] = $this->hearts_db->getHeartsByUserId($_SESSION["user"]["id"]);
      // $this->board_list = $this->boards_db->getBoardsForUser($_SESSION["user"]);
    } else {
      // $this->board_list = $this->boards_db->getBoardsForAnon();
    }

    $this->board_list = $this->boards_db->getBoards();
  }

  // private function getUserData($userSession)
	// {
  //   $user = $this->users_db->getUser($userSession["username"]);

  //   $user["userhearts"] = $this->hearts_db->getHeartsByUserId($user["id"]);
  //   return $user;
  // }
}