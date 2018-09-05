<?php


namespace App\Controller;

Use App\Model\Users as Users;
Use App\Model\Hearts as Hearts;
Use App\Model\Posts as Posts;
Use App\Model\Comments as Comments;
use App\Core\Request as Request;

use \DateTime;
use \DateTimeZone;


class PostController
{
    /**
     *
     */
    private $posts_db;
    private $users_db;
    private $hearts_db;
    private $comments_db;
    private $error_messages = [
        "Upload successful",
        "File exceeds maximum upload size specified by default",
        "File exceeds size specified by MAX_FILE_SIZE",
        "File only partially uploaded",
        "Form submitted with no file specified",
        "",
        "No temporary folder",
        "Cannot write file to disk",
        "File type is not permitted"
    ];
    private $permitted = [
        "image/gif",
        "image/jpg",
        "image/jpeg",
        "image/png"
    ];
    private $max_file_size = 5242880;
    private $upload_dir = "/var/www/artily/public/uploads";

    private $user;

    public function __construct(\PDO $pdo) {
    	$this->posts_db = new Posts($pdo);
        $this->users_db = new Users($pdo);
        $this->hearts_db = new Hearts($pdo);
        $this->comments_db = new Comments($pdo);

    // }

    // function run() {
        if (array_key_exists('user',$_SESSION)) {
            $this->user = $this->getUserData($_SESSION["user"]);
        }

        if (isset($_GET["action"]) && $_GET["action"] == 'new') {
            if (isset($_POST["submitPost"])) {
                $this->submitNewPost();
                return;
            }
            $this->renderNewPost();
            die();
        }

        // Create a post_id var
        $request = Request::$item;
        $post = null;
        if (is_numeric($request) == false && $request !== null) {
            $post = $this->posts_db->getPostByTitle($request);
        }
        if (is_numeric($request) == true && $request !== null) {
            $post = $this->posts_db->getPostById($request);
        }
        if ($post === null) {
            // No post was found for the request
            http_response_code(404);
            header("Location: /error?code=404");
            die();
        }

        if (isset($post["deleted"])) {
            http_response_code(404);
            header("Location: /error?code=404");
            die();
        }

        if (isset($_GET["action"])) {
            switch ($_GET["action"]) {
                case "edit":
                    $this->editPost();
                break;
                case "delete":
                    $this->deletePost($post);
                break;
                case "reply":
                    if (array_key_exists('user',$_SESSION) == false) {
                        redirect_back();
                        die();
                    }
                    if (!isset(Request::$item)) {
                        // Post id was not provided
                        redirect_back();
                        die();
                    }
                    if (is_numeric(Request::$item))
                            $op = $this->posts_db->getPostById(Request::$item);
                        else
                            $op = $this->posts_db->getPostByTitle(Request::$item);
                    if (isset($_POST["quickreplysubmit"])) {
                        // QUICK REPLY
                        // Is a reply to the main post
                        $this->submitNewReply($op["post_id"]);
                        return;
                    } else {
                        // Prepare to display a form page
                        if (isset($_GET["comment"]))
                        {
                            if (isset($_POST["replysubmit"]))
                            {
                                $this->submitNewReply($op["post_id"], $_GET["comment"]);
                                return;
                            }
                            // is a reply to a comment inside the post thread
                            $this->displayReplyForm($op, $_GET["comment"]);
                        }
                        else
                        {
                            if (isset($_POST["replysubmit"]))
                            {
                                $this->submitNewReply($op["post_id"]);
                                return;
                            }
                            // is a reply to the main post
                            $this->displayReplyForm($op);
                        }
                    }
                break;
                default:
                    header("Location: /error?code=404");
                    die();
                break;
            }
        }

        // No action defined, display the post
        // var_dump($post);
        // die();
        $this->renderPost($post);
    }

    private function updatePost() {

        if (isset($_POST["confirmupdate"])) {
            // update logic
            // $this->posts_db->updatePost($post["post_id"]);
            // Pop up message of update success
            // Render post view page
        } else {
            // Show update page
            // Render the post
            // A form with textarea etc underneath that contains the post contents
            // Submit button with name 'confirmupdate'
            $this->renderUpdate();
        }
    }

    private function deletePost($post) {
        if (array_key_exists('user',$_SESSION) == false) { 
            // User isn't logged in
            http_response_code(403);
            header("Location: /error?code=403");
            die();
        }
        if ($_SESSION["user"]["id"] !== $post["user_id"]) {
            // User isn't the author, thus unauthorized
            http_response_code(401);
            header("Location: /error?code=401");
            die();
        }
        if (isset($_POST["confirmdelete"]) && isset($_POST["submitdelete"])) {
            // Delete logic
            $result = $this->posts_db->deletePostById($post["post_id"]);
            // Render success message
            // Redirect to the artboard index page after 3 seconds?
            $board = Request::$board;
            var_dump($result);
            // header("Location: /board/$board?status=postdeleted");
            die();
        } else {
            // Show confirmation page
            // Render the post, with a confirmation form submit button name of 'confirmdelete'
            // Also with a checkbox ARE YOU SURE???
            // Header shouldn't change
            include_once('views/posts/delete_post.php');
            die();
        }
    }

    function displayReplyForm(array $op, int $comment_id = 0) {
        if ($comment_id !== 0) {
            // no parent_comment_id
            $comment = $this->comments_db->getCommentById($comment_id);
        }
        // $post = $this->posts_db->getPostByTitle($post_title);
        if (array_key_exists('user',$_SESSION)) {
            $user = $this->getUserData($_SESSION["user"]);
        }
        include("views/posts/reply.php");
    }

    function submitNewReply(int $id, int $comment_id = NULL) {
        $post_data = array();
        $post_data["post_id"] = $id;
        $post_data["content"] = $_POST["content"] ?? '';
        $post_data["user_id"] = $_SESSION["user"]["id"];
        $post_data["parent_comment_id"] = $comment_id;
        $result = $this->comments_db->create_comment($post_data);

        if (isset($result))
            header("Location: ".Request::$path);
            die();
    }

    function renderPost($post) {
        // $post = $this->posts_db->getPostById($id);
        if (array_key_exists('user',$_SESSION)) {
            $user = $this->getUserData($_SESSION["user"]);
        }
        $response = $this->comments_db->getCommentsByPostId($post["post_id"]);
        $comments = $response["tree"];
        include "views/posts/view_post.php";
        die();
    }

    function renderPostByTitle(string $post_title) {
        $post_title = str_replace('-', ' ', $post_title);
        $post = $this->posts_db->getPostByTitle($post_title);
        if (array_key_exists('user',$_SESSION)) {
            $user = $this->getUserData($_SESSION["user"]);
        }
        $response = $this->comments_db->getCommentsByPostId($post["post_id"]);
        $comments = $response["tree"];
        include "views/posts/view_post.php";
        die();
    }

    function submitNewPost() {
        $file = $_FILES["image"];
        $file_name = basename($file["tmp_name"]);
        $file_type = $file["type"];
        $new_file_name = "";
        if (file_exists($file["tmp_name"])) {
            // Php errors
            if (!empty($file["error"])) {
                $error = $file["error"];
                echo $this->error_messages[$error];
                include "views/posts/new_post.php";
                die();
            }

            // File size error
            if ($file["size"] > $this->max_file_size) {
                echo "File size is too large (max 5mb)";
                include "views/posts/new_post.php";
                die();
            }

            // File extension error
            if (in_array($file_type, $this->permitted) == false || exif_imagetype($file["tmp_name"]) == false) {
                echo "The file '$file_name' is not a permitted file format";
                include "views/posts/new_post.php";
                die();
            }

            // Create unique file name
            function generate_file_name($username, $target) {
                return md5($username . microtime()) .'.'. pathinfo($target, PATHINFO_EXTENSION);
            }

            $new_file_name = generate_file_name($_SESSION["user"]["username"], $file["name"]);
            while (file_exists($new_file_name)) {
                $new_file_name = generate_file_name($_SESSION["user"]["username"], $file["name"]);
            }
            
            // All checks okay, add to upload folder
            move_uploaded_file($file["tmp_name"], $this->upload_dir .'/'. $new_file_name);
        }

        $post_data = [
            "board_id" => 1,
            "nsfw" => "",
            "file_path" => "",
            "file_name" => "",
            "file_type" => "",
            "width" => "",
            "height" => ""
        ];
        $post_data["user_id"] = $_SESSION["user"]["id"];
        $post_data["title"] = $_POST["title"];
        $post_data["content"] = $_POST["content"];
        if ($file["name"]) {
            $post_data["file_path"] = $new_file_name;
            $post_data["file_name"] = pathinfo($file["name"], PATHINFO_FILENAME);
            $post_data["file_type"] = pathinfo($file["name"], PATHINFO_EXTENSION);
            $file_size = getimagesize($this->upload_dir .'/'. $new_file_name);
            $post_data["width"] = $file_size[0];
            $post_data["height"] = $file_size[1];
        }
        // Add all data to database
        $result = $this->posts_db->create_post($post_data);
        // Redirect to the new post
        var_dump($result);
        header("Location: /posts/$result?status=postsuccess");
        die();
    }

    function renderNewPost() {
        if (array_key_exists('user',$_SESSION) == false) {
            // $user = $this->getUserData($_SESSION["user"]);
            http_response_code(403);
            header("Location: /error?code=403");
            die();
        }
        include "views/posts/new_post.php";
    }

    public function getUserData($userSession) {
    	$user = $this->users_db->getUser($userSession["username"]);

    	$user["userhearts"] = $this->hearts_db->getHeartsByUserId($user["id"]);
    	return $user;
    }
}
