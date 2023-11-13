<?php

namespace App\Controllers;

class AdminHomeController extends BaseController
{
    public function welcomeAction()
    {
        $user = $this->loginUser;
        var_dump($user);
        $this->view('adminWelcome', [
            'user' => $user
        ]);
    }
}