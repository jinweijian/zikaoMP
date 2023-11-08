<?php

namespace App\Model;

abstract class BaseModel
{
    public $table = "";

    public function get($id)
    {
        $sql = "SELECT * FROM {$this->table} WHERE id = ?";
        $res = $this->pdo()->prepare($sql, [$id]);
        if ($res === false) {
            return [];
        }
        return $res->fetch();
    }

    /**
     * @return \PDO
     */
    protected function pdo()
    {
        return \MysqlSingleton::getInstance()->getConnection();
    }
}
