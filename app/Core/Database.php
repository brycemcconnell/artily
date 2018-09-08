<?php

namespace App\Core;

use PDO;

include_once 'secret.php';

class Database {
	private $host = 'localhost:3306';
	private $db = 'artily';
	private $user = USERNAME;
	private $pass = PASSWORD;
	private $charset = 'utf8mb4';

	public $pdo;

	public function __construct() {
		$dsn = "mysql:host=$this->host;dbname=$this->db;charset=$this->charset";
		$opt = [
		    PDO::ATTR_ERRMODE => PDO::ERRMODE_EXCEPTION,
		    PDO::ATTR_DEFAULT_FETCH_MODE => PDO::FETCH_ASSOC,
		];

		$this->pdo = new PDO($dsn, $this->user, $this->pass, $opt);
	}
}

