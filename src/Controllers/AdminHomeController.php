<?php

namespace App\Controllers;

class AdminHomeController extends BaseController
{
    public function welcomeAction()
    {
        $user = $this->loginUser;
        $this->view('adminWelcome', [
            'user' => $user
        ]);
    }
}