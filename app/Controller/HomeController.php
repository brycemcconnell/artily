<?php


namespace App\Controller;


class HomeController
{
    /**
     *
     */

    private $pagePath = '/';

    function home_page()
    {
        $page_path = $this->pagePath;
        include "views/home.php";
    }
}