<?php

namespace App\Core;

use App\Core\Request as Request;

include_once('Database.php');

use App\Core\Database as Database;

class Router {

	/**
	 *	@param string $uri
	 *	@param string $query
	 *	@param function $func
	*/
	private static function request($uri, $query, $func): void
	{
		// Check if the request uri matches route uri
		if (Request::$page !== $uri)
			return;
		
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

		// All checks complete, route was a match
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