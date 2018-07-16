<?php

namespace App;

use App\Utils\MYREQ as MYREQ;

class Router {

	public static $routes = array();
	public static $routeFound = false;

	public static function set($route, $function) {
		self::$routes[$route] = $function;

		// print_r(self::$routes);
		$url = MYREQ::$page ?? 'index.php';
		if ($url == $route) {
		// 	var_dump($route);
			$function->__invoke();
			self::$routeFound = true;
		}
	}
}