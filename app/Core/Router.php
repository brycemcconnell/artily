<?php

namespace App\Core;

use App\Core\Request as Request;

include_once('Database.php');

use App\Core\Database as Database;

class Router {

	static $items = [];

	private static function startsWith($haystack, $needle)
	{
		$length = strlen($needle);
		return (substr($haystack, 0, $length) === $needle);
	}

	private static function endsWith($haystack, $needle)
	{
		return substr($haystack, -strlen($needle)) === $needle;
	}

	/**
	 *	@param string $uri
	 *	@param string $query
	 *	@param function $func
	*/
	private static function request($uri, $query, $func): void
	{
		// Separate this route's values into an array, just like Request::$values
		$route_values = array_filter(explode("/", substr($uri, 0)));

		// Some ease of use stuff
		$parts_given = count(Request::$values);
		$matches_needed = count($route_values);
		$matches = 0;

		// If the request argument count isn't the argument count of the route, it must be a different route
		if ($parts_given != $matches_needed) {
			return;
		}

		// Iterate over route values and compare with request values if necessary
		foreach ($route_values as $key => $value) {

			// Check if the current part of the route uri is a wildcard, if so any request value is fine
			if (Router::startsWith($value, '{') && Router::endsWith($value, '}')) {
				// echo 'wildcard:<br>Key: '.trim($value, "{}").'<br>Val: '.Request::$values[$key].'<br>';
				Router::$items[trim($value, "{}")] = Request::$values[$key];
				$matches += 1;
				continue;
			}

			// Check if current part of the request uri is equal to the equivalent part of the route
			if (Request::$values[$key] === $route_values[$key]) {
				$matches += 1;
			}
		}

		// If part of the request URI didn't match this route uri
		if ($matches !== $matches_needed) {
			return;
		}

		// Success, this is the correct route.
		
		// Check if there is a query in the request
		if (empty(Request::$query) == false) {
			// There is a query request!
			// Check if there is a query in the route
			if (empty($query)) { 
				// This route has no query, it must be wrong
				return;
			}
			// This route has a query!
			// Check if this route's query is inside the request query
			if (array_key_exists($query, Request::$query) == false) {
				// This route's query is not in the request query!
				return;
			}
		}

		// All checks complete, invoke route logic
		$func->__invoke(new Database());
		die();
	}

	/**
	 *	@param string $uri
	 *	@param string $query
	 *	@param function $func
	*/
	public static function get($uri, $query, $func): void
	{
		// Check if the request is get
		if (Request::$method !== "GET")
			return;
		
		self::request($uri, $query, $func);
	}

	/**
	 *	@param string $uri
	 *	@param string $query
	 *	@param function $func
	*/
	public static function post($uri, $query, $func): void
	{
		// Check if the request is post
		if (Request::$method !== "POST")
			return;
		
		self::request($uri, $query, $func);
	}
}