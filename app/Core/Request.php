<?php

namespace App\Core;

class Request {

	static $values;
	static $count;
	static $path;

	static $method;
	static $query;

	static function init() {
		Request::$path = parse_url($_SERVER["REQUEST_URI"])["path"];
		Request::$values = array_filter(explode("/", substr(Request::$path, 1)));
		Request::$count = count(Request::$values);
		Request::$method = $_SERVER["REQUEST_METHOD"];
		// Request::$query = $_SERVER["QUERY_STRING"];
		$array = [];
		if (isset($_SERVER["QUERY_STRING"]))
			parse_str($_SERVER["QUERY_STRING"], $array);
		Request::$query = $array;
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
		print_r("path:           " . Request::$path . "\n");
		echo "<br>SERVER:<br>";
		var_dump($_SERVER);
		echo "</pre>";
	}
}

Request::init();