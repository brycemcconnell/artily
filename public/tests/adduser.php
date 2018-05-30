<?php


include_once '../../config.php';

include_once('UserDB.php');


$db = new UserDB($pdo);

$n='tom';
$user = ['username'=>"{$n}", 'email'=>"{$n}@example.com", 'password'=>"{$n}"];
echo $db->addUser($user);

echo '<br>test password<br>';
var_dump($db->authenticateUser('tom', 'tom'));
echo 'test get by username<br>';
var_dump($db->getUserbyUsername('bob'));
/*
echo 'test change password<br>';
var_dump($db->changePassword('bob', 'bobby', 'bob'));

echo 'test change password<br>';
var_dump($db->changePassword('bob', 'bobby', 'bobby'));
*/