<?php

namespace App\Controllers;

use App\Model\UserModel;

class UserController extends BaseController
{
    public function login()
    {
        // 显示登录页面
        $this->view('login');
    }

    public function processLogin()
    {
        // 处理登录请求

        // 获取用户提交的用户名和密码
        $username = $_POST['username'] ?? '';
        $password = $_POST['password'] ?? '';

        // 根据用户名查询用户信息
        $userModel = new UserModel();
        $user = $userModel->findByUsername($username);

        if ($user && password_verify($password, $user['password'])) {
            // 用户名和密码验证成功

            // 生成一个新的 session_id
            $sessionId = $userModel->generateRandomSessionId();

            // 更新用户的 session_id
            $userModel->updateSessionId($user['id'], $sessionId);

            // 将 session_id 存储到用户的 Cookie 中
            setcookie('sessionId', $sessionId, time() + 3600, '/');

            // 登录成功后，可以重定向到其他页面或执行其他操作
            header('Location: /');
            exit();
        } else {
            // 用户名或密码错误，显示错误信息或重定向到登录页面
            header('Location: /login?error=1'); // 重定向到登录页面并传递错误参数
            exit();
        }
    }

    public function logout()
    {
        // 处理用户登出

        // 清除用户的 session_id
        $userModel = new UserModel();
        $userModel->updateSessionId($this->loginUser['id'], null);

        // 清除用户的 Cookie
        setcookie('sessionId', '', time() - 3600, '/');

        // 登出后，可以重定向到其他页面或执行其他操作
        header('Location: /'); // 你的重定向目标页面
        exit();
    }
}
