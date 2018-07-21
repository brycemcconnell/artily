<?php

namespace App\Controller;

class ErrorController {

	private $errorCodes;

	public function __construct()
	{
		$this->errorCodes = [
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
	}

	public function run(): void
	{
		if (isset($_GET["code"]) && array_key_exists($_GET["code"], $this->errorCodes)) {
			$this->render($_GET["code"]);
			return;
		}
        header("Location: /error?code=404");
   		die();
	}

	public function render($code): void
	{
		$error = [$code => $this->errorCodes[$code]];
		$big = $code == 418 || $code == 420 ? "big-text" : "";
		include "views/error/error.php";
	}
}