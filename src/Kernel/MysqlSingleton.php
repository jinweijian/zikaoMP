<?php

namespace App\Kernel;

class MysqlSingleton
{
    private static $instance;
    private $connection;
    private $config;

    private function __construct()
    {
        $this->config = include(__DIR__ . '/../../config/mysql.config.php');
        $this->connection = new \PDO("mysql:host={$this->config['servername']};dbname={$this->config['dbname']}", $this->config['username'], $this->config['password']);
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
