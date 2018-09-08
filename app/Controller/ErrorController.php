<?php

namespace App\Controller;

class ErrorController {

	private $errorCodes = [
		400 => 'Bad Request',
		401 => 'Unauthorized',
		403 => 'Forbidden',
		404 => 'Not Found',
		418 => "☕",
		420 => "🔥",
		500 => 'Internal Server Error',
		502 => 'Bad Gateway',
		503 => 'Service Unavailable',
		504 => 'Gateway Timeout'
	];

	private $error_code;

	public function __construct($query)
	{
		$this->error_code = 404;
		if (isset($query["code"]) && array_key_exists($query["code"], $this->errorCodes)) {
			$this->error_code = $query["code"];
		}
	}

	public function render(): void
	{
		
        $error = [
			$this->error_code => $this->errorCodes[$this->error_code]
		];
		$big = $this->error_code == 418 || $this->error_code == 420 ? "big-text" : "";
		header($_SERVER["SERVER_PROTOCOL"]." $this->error_code"); 
		include "views/error/error.php";
	}
}