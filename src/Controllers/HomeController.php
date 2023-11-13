<?php

namespace App\Controllers;

class HomeController extends BaseController
{
    public function welcomeAction()
    {
        $this->view('welcome');
    }
}