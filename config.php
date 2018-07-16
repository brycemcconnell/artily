<?php

declare(strict_types=1); //optional

set_include_path(__DIR__ . PATH_SEPARATOR . get_include_path());

define('APP_ROOT', 'http://artily.local'); //no trailing '/', empty string or fully qualified name for root


session_start();

include_once 'secret.php';
$host = 'localhost';
$db = 'artily';
$user = USERNAME;
$pass = PASSWORD;
$charset = 'utf8mb4';

$dsn = "mysql:host=$host;dbname=$db;charset=$charset";
$opt = [
    PDO::ATTR_ERRMODE => PDO::ERRMODE_EXCEPTION,
    PDO::ATTR_DEFAULT_FETCH_MODE => PDO::FETCH_ASSOC,
];

$pdo = new PDO($dsn, $user, $pass, $opt);
include_once 'app/Utils/utils.php';
include_once 'app/Utils/MYREQ.php';
