<?php

namespace App;

use App\Model\UserModel;

class App
{
    public function run()
    {
        $requestUri = $_SERVER['REQUEST_URI'];
        $requestMethod = $_SERVER['REQUEST_METHOD'];

        // 解析路由
        $route = $this->parseRoute($requestUri);

        $user = [];
        // 检查路由是否在白名单中
        if (!$this->isRouteInWhitelist($route)) {
            // 获取用户身份信息
            $sessionId = $_COOKIE['sessionId'] ?? null;

            if ($sessionId) {
                $user = $this->authenticateUser($sessionId);
                // 更新活跃时间

            } else {
                // 用户未登录
                header("HTTP/1.0 401 Unauthorized");
                echo "401 Unauthorized";
                exit();
            }
        }
        // 获取控制器类名和方法名
        $controllerClass = "\\App\\Controllers\\" . ucfirst($route['controller']) . 'Controller';
        $method = $route['action'];
        $method .= 'Action';

        $params = $route['params'] ?? [];
        // 实例化控制器并调用方法
        if (class_exists($controllerClass)) {
            $controller = new $controllerClass($user, $params);
            if (method_exists($controller, $method)) {
                $controller->$method();
            } else {
                $this->notFound();
            }
        } else {
            $this->notFound();
        }
    }

    private function parseRoute($requestUri)
    {
        $uriParts = explode('/', trim($requestUri, '/'));
        $controller = 'home';
        if (!empty($uriParts[0])) {
            $controller = $this->convertToCamelCase($uriParts[0]);
        }
        $action = $this->convertToCamelCase($uriParts[1] ?? 'welcome');
        $params = array_slice($uriParts, 2);

        return [
            'controller' => $controller,
            'action' => $action,
            'params' => $params,
        ];
    }

    private function convertToCamelCase($input)
    {
        // 使用 ucwords 将每个单词的首字母大写
        // 使用 str_replace 将下划线替换为空格
        // 使用 lcfirst 将第一个单词的首字母小写
        return lcfirst(str_replace(' ', '', ucwords(str_replace('_', ' ', $input))));
    }

    private function notFound()
    {
        header("HTTP/1.0 404 Not Found");
        echo "404 Not Found";
        exit();
    }

    private function reHome()
    {
        header("Location: /home/welcome");
        exit();
    }


    private function authenticateUser($sessionId)
    {
        $userModel = new UserModel();
        $user = $userModel->findBySessionId($sessionId);

        if (!empty($user)) {
            // 用户已登录，可以进行相关操作
            return $user;
        } else {
            // 用户未登录
           $this->reHome();
        }
    }

    private function isRouteInWhitelist($route)
    {
        $whitelist = [
            'user/login',
            'user/processLogin',
            'user/logout',
            'home/welcome',
        ];

        return in_array($route['controller'] . '/' . $route['action'], $whitelist);
    }

}
