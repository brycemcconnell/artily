<?php
namespace App\Model;

include_once('app/Utils/Validation.php');

use PDO;
use App\Utils\Validation as Validation;

class Comments {
	private $pdo;

	public function __construct(\PDO $pdo) {
		$this->pdo = $pdo;
	}

	public function close(): void {
		$this->pdo = null;
	}

	public function getCommentsByPostId(int $post_id): array
	{
		$sql = '
			SELECT
				comments.*,
				comment_contents.content,
				users.username
			FROM
				users,
				comments,
				comment_contents
			WHERE
				comments.post_id = :post_id
			AND
				comments.id = comment_contents.comment_id
			AND
				comments.user_id = users.id
			ORDER BY
				comments.created;
		';
		$stmt = $this->pdo->prepare($sql);
		$stmt->bindValue(':post_id', $post_id, PDO::PARAM_INT);
		$stmt->execute();
		$comments = $stmt->fetchAll();
		foreach ($comments as $key => $value) {
			$comments[$key]["elapsed"] = time_elapsed_string($comments[$key]["created"]);
		}
		function buildTree(array $elements, $parentId = 0) {
		    $branch = array();

		    foreach ($elements as $element) {
		        if ($element['parent_comment_id'] == $parentId) {
		            $children = buildTree($elements, $element['id']);
		            $element['children'] = [];
		            if ($children) {
		                $element['children'] = $children;
		            }
		            $branch[] = $element;
		        }
		    }
		    return $branch;
		}

		$tree = buildTree($comments);

		return $tree;
	}

	public function getCommentsByCommentId(int $id): void
	{

	}
}