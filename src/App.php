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
        // 获取用户身份信息
        $sessionId = $_COOKIE['sessionId'] ?? null;
        if ($this->isLoginPage($requestUri) && !empty($this->getUser($sessionId))) {
            $this->redirectAdminHome();
        }

        // 检查路由是否在白名单中
        if (!$this->isRouteInWhitelist($route)) {

            if ($sessionId) {
                $user = $this->authenticateUser($sessionId);
                // 更新活跃时间

            } else {
                // 用户未登录
                $this->redirectHome();
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
        // 解析路由
        $uriParts = explode('?', $requestUri, 2);
        $path = $uriParts[0];
        $params = $uriParts[1] ?? '';

        $pathParts = explode('/', trim($path, '/'));

        $controller = 'home';
        if (!empty($pathParts[0])) {
            $controller = $this->convertToCamelCase($pathParts[0]);
        }

        $action = $this->convertToCamelCase($pathParts[1] ?? 'welcome');
        $params = $this->parseParams($params);

        return [
            'controller' => $controller,
            'action' => $action,
            'params' => $params,
        ];
    }

    private function parseParams($params)
    {
        // 解析参数字符串为关联数组
        $paramArray = [];
        parse_str($params, $paramArray);

        return $paramArray;
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

    private function redirectHome()
    {
        header("Location: /home/welcome");
        exit();
    }

    private function redirectAdminHome()
    {
        header("Location: /admin_home/welcome");
        exit();
    }

    private function isLoginPage($requestUri)
    {
        // 根据实际情况判断是否访问登录页面
        return strpos($requestUri, '/user/login') !== false;
    }

    private function authenticateUser($sessionId)
    {
        $user = $this->getUser($sessionId);

        if (!empty($user)) {
            // 用户已登录，可以进行相关操作
            return $user;
        } else {
            // 用户未登录
           $this->redirectHome();
        }
    }

    private function getUser($sessionId)
    {
        if (empty($sessionId)) {
            return [];
        }
        $userModel = new UserModel();
        return $userModel->findBySessionId($sessionId);
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
