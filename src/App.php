<?php

namespace App;

class App
{
    public function run()
    {
        $requestUri = $_SERVER['REQUEST_URI'];
        $requestMethod = $_SERVER['REQUEST_METHOD'];

        // 解析路由
        $route = $this->parseRoute($requestUri);

        // 获取控制器类名和方法名
        $controllerClass = "\\App\\Controllers\\" . ucfirst($route['controller']) . 'Controller';
        $method = strtolower($requestMethod) . ucfirst($route['action']);

        // 实例化控制器并调用方法
        if (class_exists($controllerClass)) {
            $controller = new $controllerClass();
            if (method_exists($controller, $method)) {
                $controller->$method($route['params']);
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

        $controller = isset($uriParts[0]) ? $uriParts[0] : 'home';
        $action = isset($uriParts[1]) ? $uriParts[1] : 'index';
        $params = array_slice($uriParts, 2);

        return [
            'controller' => $controller,
            'action' => $action,
            'params' => $params,
        ];
    }

    private function notFound()
    {
        header("HTTP/1.0 404 Not Found");
        echo "404 Not Found";
        exit();
    }
}