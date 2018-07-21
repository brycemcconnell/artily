<?php

namespace App\Core;

class Request {

	static $values;
	static $count;
	static $page;
	static $path;
	static $item;
	// static $query;
	static $board;

	static $method;
	static $query;
	static $api;

	static function init() {
		$temp_url = parse_url($_SERVER["REQUEST_URI"]);
		Request::$path = $temp_url["path"];
		Request::$values = array_filter(explode("/", substr(Request::$path, 1)));
		Request::$count = count(Request::$values);
		Request::$method = $_SERVER["REQUEST_METHOD"];
		// Request::$query = $_SERVER["QUERY_STRING"];
		parse_str($_SERVER["QUERY_STRING"], $array);
		Request::$query = $array;
		Request::$api = 'views';

		switch (Request::$count) {
			case 0:
				Request::$page = "index.php";
			break;
			case 1:
				Request::$page = Request::$values[0];
			break;
			case 2:
				Request::$page = Request::$values[0];
				Request::$item = Request::$values[1];
			break;
			case 3:
				Request::$page = Request::$values[1];
				Request::$item = Request::$values[2];
			break;
			case 4:
				Request::$board = Request::$values[1];
				Request::$page = Request::$values[2];
				Request::$item = Request::$values[3];
			break;
			default:
				Request::$page = end(Request::$values);
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
	    echo "Request vars\n";
	   	print_r("values:\n");
	   	var_dump(Request::$values);
	    print_r("count:          " . Request::$count . "\n");
	    print_r("page:           " . Request::$page . "\n");
	    print_r("path:           " . Request::$path . "\n");
	    print_r("item:           " . Request::$item . "\n");
	    print_r("board:           " . Request::$board . "\n");
	    echo "</pre>";
	}
}

Request::init();