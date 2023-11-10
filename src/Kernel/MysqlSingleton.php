<?php

namespace App\Kernel;
require_once  __DIR__ . '/../../config/mysql.config.php';

class MysqlSingleton
{
    private static $instance;
    private $connection;

    private function __construct()
    {
        global $mysqlConfig;
        $this->connection = new \PDO("mysql:host={$mysqlConfig['servername']};dbname={$mysqlConfig['dbname']}", $mysqlConfig['username'], $mysqlConfig['password']);
    }

    public static function getInstance()
    {
        if (!self::$instance) {
            self::$instance = new self();
        }
        return self::$instance;
    }

    public function getConnection()
    {
        return $this->connection;
    }

    public function query($sql)
    {
        return $this->connection->query($sql);
    }

    // 防止对象被复制
    public function __clone()
    {
        trigger_error('Clone is not allowed.', E_USER_ERROR);
    }
}
