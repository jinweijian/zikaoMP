<?php

namespace App\Controllers;

abstract class BaseController
{
    protected $loginUser = []; // TODO 换成类

    public function __construct($loginUser = [])
    {
        $this->loginUser = $loginUser;
    }

    protected function view($slug)
    {
        // 显示登录页面
        include __DIR__ . "../../public/View/{$slug}.php";
    }
}
