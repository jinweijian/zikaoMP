<?php

namespace App\Controllers;

abstract class BaseController
{
    protected $loginUser = []; // TODO 换成类

    protected $params = [];

    public function __construct($loginUser = [], $params = [])
    {
        $this->loginUser = $loginUser;
        $this->params = $params;
    }

    protected function view($slug, $data = [])
    {
        extract($data);
        // 显示登录页面
        include __DIR__ . "/../../public/View/{$slug}.php";
    }

    protected function location($path)
    {
        header("Location: {$path}");
        exit();
    }
}
