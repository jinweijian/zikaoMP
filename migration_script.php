<?php

// 引入数据库配置文件
$mysqlConfig = include(__DIR__ . '/config/mysql.config.php');
try {
    // 创建连接
    $conn = new PDO("mysql:host={$mysqlConfig['servername']};dbname={$mysqlConfig['dbname']}", $mysqlConfig['username'], $mysqlConfig['password']);

    // 设置 PDO 错误模式为异常
    $conn->setAttribute(PDO::ATTR_ERRMODE, PDO::ERRMODE_EXCEPTION);

    // 获取 SQL 目录下的所有 SQL 文件
    syncSqlByDir($conn, 'sql');

    // 同步触发器
    triggerMigration($conn);

    // 同步存储过程
    procedureMigration($conn);

    // 同步视图
    viewMigration($conn);

    // 同步测试数据
    initDataMigration($conn);

} catch (PDOException $e) {
    echo "Connection failed: " . $e->getMessage() . "\n";
}

function syncSqlByDir(PDO $conn, $dirname)
{
    // 获取 SQL 目录下的所有 SQL 文件
    $sqlFiles = glob($dirname . '/*.sql');

    // 逐个执行 SQL 文件中的 SQL 语句
    foreach ($sqlFiles as $sqlFile) {
        $sqlScript = file_get_contents($sqlFile);
        try {
            // 检查表是否存在
            $conn->exec($sqlScript);
            echo "Migration completed successfully.\n";
        } catch (PDOException $e) {
            echo "Error: " . $e->getMessage() . "\n";
        }
    }
}

function procedureMigration(PDO $conn)
{
    // 创建存储过程
    syncSqlByDir($conn, 'sql/procedure');
}

function viewMigration(PDO $conn)
{
    // 创建视图
    syncSqlByDir($conn, 'sql/view');
}

function triggerMigration(PDO $conn)
{
    // 创建触发器
    syncSqlByDir($conn, 'sql/trigger');
}

function initDataMigration(PDO $conn)
{
    // 初始化数据
    syncSqlByDir($conn, 'sql/initData');
}
