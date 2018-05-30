<?php

include_once '../../config.php';

include_once('app/model/BookingsDB.php');

use BookingApp\Model\BookingsDB as BookingsDB;

// create controllers

$db = new BookingsDB($pdo);
$r = $db->authenticateUser("toma", "tom");

if ($r === false){
    echo "FALSE";

}
else{
    echo "TRUE";
}
