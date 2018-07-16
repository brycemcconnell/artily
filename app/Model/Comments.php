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

	public function create_comment(array $post_data)
	{
		$sql = '
			INSERT INTO
				comments (
					post_id,
					created,
					user_id,
					parent_comment_id
				)
			VALUES
				(
					:post_id,
					UTC_TIMESTAMP(),
					:user_id,
					:parent_comment_id
				);
			INSERT INTO
				comment_contents (
					comment_id,
					content
				)
			VALUES (
				LAST_INSERT_ID(),
				:content
			);
		';
		$stmt = $this->pdo->prepare($sql);
		$stmt->bindValue(':post_id', $post_data["post_id"], PDO::PARAM_INT);
		$stmt->bindValue(':user_id', $post_data["user_id"], PDO::PARAM_INT);
		$stmt->bindValue(':parent_comment_id', $post_data["parent_comment_id"], PDO::PARAM_INT);
		$stmt->bindValue(':content', $post_data["content"], PDO::PARAM_STR);
		$stmt->execute();
		return $this->pdo->lastInsertId();
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
				comments.created DESC;
		';
		$stmt = $this->pdo->prepare($sql);
		$stmt->bindValue(':post_id', $post_id, PDO::PARAM_INT);
		$stmt->execute();
		$comments = $stmt->fetchAll();
		$comment_total_count = count($comments);
		foreach ($comments as $key => $value) {
			$comments[$key]["elapsed"] = time_elapsed_string($comments[$key]["created"]);
		}
		function buildTree(array $elements, $parentId = 0) {
		    $branch = array();

		    foreach ($elements as $element) {
		        if ($element['parent_comment_id'] == $parentId) {
		            $children = buildTree($elements, $element['id']);
		            $element["child_count"] = 0;
		            $element["user_url"] = "/user/".urlsafe($element["username"]);
		            $element['children'] = [];
		            if ($children) {
		                $element['children'] = $children;
		            }
		            $element["child_count"] = count($element['children']);
		            $branch[] = $element;
		        }
		    }
		    return $branch;
		}

		$tree = buildTree($comments);
		
		// Count descendants and calculate
		function array_tree($tree) {     
			$result = array();     
			foreach($tree as $node) {
		        if (count($node["children"])) {
		            $result = array_tree($node["children"]);
		        }

		        $result[] = $node["id"];
		    }
		    return $result;
		}
		$result = array_tree($tree);
		$response = array();
		$response["count"] = $comment_total_count;
		$response["tree"] = $tree;
		return $response;
	}

	public function getCommentById(int $id)
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
				comments.id = :id
			AND
				comments.id = comment_contents.comment_id
			AND
				comments.user_id = users.id;
		';
		$stmt = $this->pdo->prepare($sql);
		$stmt->bindValue(':id', $id, PDO::PARAM_INT);
		$stmt->execute();
		$comment = $stmt->fetch();
		$comment["user_url"] = "/user/".urlsafe($comment["username"]);
		$comment["elapsed"] = time_elapsed_string($comment["created"]);
		return $comment;
	}
	public function getCommentsByCommentId(int $id): void
	{

	}
}