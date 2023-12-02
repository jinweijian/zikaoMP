<?php

namespace App\Model;

abstract class BaseModel
{
    public $table = "";

    public function get($id)
    {
        $sql = "SELECT * FROM `{$this->table}` WHERE id = ?";
        $stmt = $this->pdo()->prepare($sql);
        $stmt->execute([$id]);

        return $stmt->fetch(\PDO::FETCH_ASSOC);
    }

    public function create(array $data)
    {
        $columns = implode(', ', array_keys($data));
        $values = implode(', ', array_fill(0, count($data), '?'));

        $sql = "INSERT INTO `{$this->table}` ({$columns}) VALUES ({$values})";
        $stmt = $this->pdo()->prepare($sql);
        $res = $stmt->execute(array_values($data));
        if (!$res) {
            systemLog('error', "sql error: {$sql}", $stmt->errorInfo());
        }

        return $this->pdo()->lastInsertId();
    }

    public function delete($id)
    {
        $sql = "DELETE FROM `{$this->table}` WHERE id = ?";
        $stmt = $this->pdo()->prepare($sql);
        $res = $stmt->execute([$id]);
        if (!$res) {
            echo "当前数据不允许删除。请检查";
            exit();
        }

        return $stmt->rowCount();
    }

    public function update($id, array $data)
    {
        $columns = '';
        foreach ($data as $key => $value) {
            $columns .= $key . ' = ?, ';
        }
        $columns = rtrim($columns, ', ');

        $sql = "UPDATE `{$this->table}` SET {$columns} WHERE id = ?";
        $values = array_values($data);
        $values[] = $id;

        $stmt = $this->pdo()->prepare($sql);
        $stmt->execute($values);

        return $stmt->rowCount();
    }


    public function search(array $conditions, array $orderBy = [], int $start = 0, int $limit = 10, array $columns = [])
    {
        $columns = $columns ? implode(', ', $columns) : '*';

        $where = '';
        if (!empty($conditions)) {
            $where = 'WHERE ' . implode(' AND ', array_map(function ($key, $value) {
                    return "$key = ?";
                }, array_keys($conditions), $conditions));
        }

        $order = '';
        if (!empty($orderBy)) {
            $order = 'ORDER BY ' . implode(', ', array_map(function ($key, $value) {
                    return "$key $value";
                }, array_keys($orderBy), $orderBy));
        }

        $sql = "SELECT {$columns} FROM `{$this->table}` {$where} {$order} LIMIT {$start}, {$limit}";
        $stmt = $this->pdo()->prepare($sql);
        $stmt->execute(array_values($conditions));

        return $stmt->fetchAll(\PDO::FETCH_ASSOC);
    }

    public function all()
    {
        $sql = "SELECT * FROM `{$this->table}`";
        $stmt = $this->pdo()->query($sql);

        return $stmt->fetchAll(\PDO::FETCH_ASSOC);
    }

    public function batchCreate(array $data)
    {
        foreach ($data as $item) {
            $this->create($item);
        }
    }

    public function batchDelete(array $data)
    {
        foreach ($data as $id) {
            $this->delete($id);
        }
    }

    public function count()
    {
        $sql = "SELECT count(1) as `total` FROM `{$this->table}`";
        $stmt = $this->pdo()->prepare($sql);
        $stmt->execute();
        $totalInfo = $stmt->fetch(\PDO::FETCH_ASSOC);

        return $totalInfo['total'] ?? 0;
    }

    public function executePDO($sql, $params = [])
    {
        $stmt = $this->pdo()->prepare($sql);
        $stmt->execute($params);

        return $stmt;
    }

    /**
     * @return \PDO
     */
    protected function pdo()
    {
        return \App\Kernel\MysqlSingleton::getInstance()->getConnection();
    }
}
