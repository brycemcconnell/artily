<?php
/*
*  index page responds to user actions
*  routes to the corresponding method
*  in BookingsController. 
*  No Action = load home page
 */

error_reporting(E_ALL);
ini_set('display_errors', 1);

include_once '../config.php';

include_once "app/Controller/HomeController.php";


use ModifyMe\Controller\HomeController as HomeController;

// create controllers

$homeController = new HomeController();

$action = $_GET['action'] ?? '';

switch ($action) {
    default:
        $homeController->home_page();
        break;
}
