<?php
// $_MYREQ = array();
// $_MYREQ["values"] = array_filter(explode("/", $_SERVER["REQUEST_URI"]));
// $_MYREQ["count"] = count($_MYREQ["values"]);
namespace App\Utils;

class MYREQ {

	static $values;
	static $count;
	static $page;
	static $path;
	static $item;
	static $verb;
	static $query;
	static $board;

	static function init() {
		$temp_url = parse_url($_SERVER["REQUEST_URI"]);
		MYREQ::$path = $temp_url["path"];
		MYREQ::$values = array_filter(explode("/", substr(MYREQ::$path, 1)));
		MYREQ::$count = count(MYREQ::$values);
		MYREQ::$verb = $_SERVER["REQUEST_METHOD"];
		MYREQ::$query = $_SERVER["QUERY_STRING"];

		switch (MYREQ::$count) {
			case 0:
				MYREQ::$page = "index.php";
			break;
			case 1:
				MYREQ::$page = MYREQ::$values[0];
			break;
			case 2:
				MYREQ::$page = MYREQ::$values[0];
				MYREQ::$item = MYREQ::$values[1];
			break;
			case 3:
				MYREQ::$page = MYREQ::$values[1];
				MYREQ::$item = MYREQ::$values[2];
			break;
			case 4:
				MYREQ::$board = MYREQ::$values[1];
				MYREQ::$page = MYREQ::$values[2];
				MYREQ::$item = MYREQ::$values[3];
			break;
			default:
				MYREQ::$page = end(MYREQ::$values);
			break;
		}
	}

	static function print_debug($reason) {
	    echo "<pre>";
	    echo "$reason\n";
	    echo "Dumping some info...\n";
	    echo "\n";
	    echo "Get Request:\n";
	    var_dump($_GET);
	    echo "\n";
	    echo "Server vars\n";
	    print_r("REDIRECT_URL:          " . $_SERVER["REDIRECT_URL"] . "\n");
	    print_r("REDIRECT_QUERY_STRING: " . ($_SERVER["REDIRECT_QUERY_STRING"] ?? "") . "\n");
	    print_r("REQUEST_METHOD:        " . $_SERVER["REQUEST_METHOD"] . "\n");
	    print_r("QUERY_STRING:          " . $_SERVER["QUERY_STRING"] . "\n");
	    print_r("REQUEST_URI:           " . $_SERVER["REQUEST_URI"] . "\n");
	    echo "\n";
	    echo "MYREQ vars\n";
	   	print_r("values:\n");
	   	var_dump(MYREQ::$values);
	    print_r("count:          " . MYREQ::$count . "\n");
	    print_r("page:           " . MYREQ::$page . "\n");
	    print_r("path:           " . MYREQ::$path . "\n");
	    print_r("item:           " . MYREQ::$item . "\n");
	    print_r("verb:           " . MYREQ::$verb . "\n");
	    print_r("query:           " . MYREQ::$query . "\n");
	    print_r("board:           " . MYREQ::$board . "\n");
	    echo "</pre>";
	}
}

MYREQ::init();