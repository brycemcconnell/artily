<?php

namespace App;

class Router {

	public static $routes = array();
	public static $routeFound = false;

	public static function set($route, $function) {
		self::$routes[$route] = $function;

		// print_r(self::$routes);
		$url = $_GET['url'] ?? 'index.php';
		
		if ($url == $route) {
		// 	var_dump($route);
			$function->__invoke();
			self::$routeFound = true;
		}
	}
}