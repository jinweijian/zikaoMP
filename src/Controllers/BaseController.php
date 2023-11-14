<?php

namespace App\Controllers;

abstract class BaseController
{
    protected $loginUser = []; // TODO 换成类

    protected $role = 'visitor';

    protected $params = [];

    public function __construct($loginUser = [], $params = [])
    {
        $this->loginUser = $loginUser;
        $this->role = $loginUser['role'] ?? 'visitor';
        $this->params = $params;
    }

    protected function isTeacher(): bool
    {
        return $this->role == 'teacher' || $this->role == 'admin';
    }

    protected function isAdmin():bool
    {
        return $this->role == 'admin';
    }

    protected function view($slug, $data = [])
    {
        $data['user'] = $this->loginUser;
        $data['isTeacher'] = $this->isTeacher();
        $data['isAdmin'] = $this->isAdmin();
        extract($data);
        // 显示登录页面
        include __DIR__ . "/../../public/View/{$slug}.php";
    }

    protected function location($path)
    {
        header("Location: {$path}");
        exit();
    }

    protected function notPermission()
    {
        header("HTTP/1.0 401 Not Permission");
        echo "401 您没有该功能/页面的权限";
        exit();
    }}
