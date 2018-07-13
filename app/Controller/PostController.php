<?php


namespace App\Controller;

include_once('app/Model/Users.php');
include_once('app/Model/Hearts.php');
include_once('app/Model/Posts.php');
include_once('app/Model/Comments.php');

Use App\Model\Users as Users;
Use App\Model\Hearts as Hearts;
Use App\Model\Posts as Posts;
Use App\Model\Comments as Comments;

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

    public function __construct(Posts $posts_db, Users $users_db, Hearts $hearts_db, Comments $comments_db) {
    	$this->posts_db = $posts_db;
        $this->users_db = $users_db;
        $this->hearts_db = $hearts_db;
        $this->comments_db = $comments_db;
    }

    function run() {
        if (isset($_GET["action"])) {
            switch ($_GET["action"]) {
                case "new":
                    // create a new post
                    if (isset($_POST["submitPost"])) {
                        $this->submitNewPost();
                        return;
                    }
                    $this->renderNewPost();
                break;
                default:
                    header("Location: /error?code=404");
                    die();
                break;
            }
        } else if (isset($_GET["id"])) {
            // view id post
            $this->renderPostById($_GET["id"]);
        } else {
            header("Location: /error?code=404");
            die();
        }
    }
    function renderPostById(int $id) {
        $post = $this->posts_db->getPostById($id);
        if (array_key_exists('user',$_SESSION)) {
            $user = $this->getUserData($_SESSION["user"]);
        }
        $comments = $this->comments_db->getCommentsByPostId($id);
        include "views/post/view_post.php";
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
                include "views/post/new_post.php";
                die();
            }

            // File size error
            if ($file["size"] > $this->max_file_size) {
                echo "File size is too large (max 5mb)";
                include "views/post/new_post.php";
                die();
            }

            // File extension error
            if (in_array($file_type, $this->permitted) == false || exif_imagetype($file["tmp_name"]) == false) {
                echo "The file '$file_name' is not a permitted file format";
                include "views/post/new_post.php";
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
            "artboard_id" => 1,
            "user_id" => 1,
            "file" => "",
            "nsfw" => "",
            "text" => "",
            "content" => ""
        ];
        $post_data["title"] = $_POST["title"];
        $post_data["content"] = $_POST["content"];
        $post_data["file_path"] = $new_file_name;
        $post_data["file_name"] = pathinfo($file["name"], PATHINFO_FILENAME);
        $post_data["file_type"] = pathinfo($file["name"], PATHINFO_EXTENSION);
        $file_size = getimagesize($this->upload_dir .'/'. $new_file_name);
        $post_data["width"] = $file_size[0];
        $post_data["height"] = $file_size[1];
        // Add all data to database
        $result = $this->posts_db->create_post($post_data);
        // Redirect to the new post
        header("Location: /post?id=$result&status=postsuccess");
        die();
    }

    function renderNewPost() {
        if (array_key_exists('user',$_SESSION) == false) {
            // $user = $this->getUserData($_SESSION["user"]);
            http_response_code(401);
            header("Location: /error?code=401");
            die();
        }
        include "views/post/new_post.php";
    }


    function renderHome()
    {
    }

    public function getUserData($userSession) {
    	$user = $this->users_db->getUser($userSession["username"]);

    	$user["userhearts"] = $this->hearts_db->getHeartsByUserId($user["id"]);
    	return $user;
    }
}
