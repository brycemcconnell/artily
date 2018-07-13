<?php


namespace App\Controller;

include_once('app/Model/Users.php');
include_once('app/Model/Comments.php');

Use App\Model\Users as Users;
Use App\Model\Comments as Comments;

class CommentController {
	private $users_db;
	private $comments_db;

	public function __construct(Users $users_db, Comments $comments_db) {
		$this->users_db = $users_db;
		$this->comments_db = $comments_db;
	}

	public function run() {
		if (isset($_GET["action"])) {
			switch ($_GET['action']) {
				case 'reply':

				break;

			}
		}
	}
}