<?php

namespace App\Model;

abstract class BaseModel
{
    public $table = "";

    public function get($id)
    {
        $sql = "SELECT * FROM {$this->table} WHERE id = ?";
        $stmt = $this->pdo()->prepare($sql);
        $stmt->execute([$id]);

        return $stmt->fetch(\PDO::FETCH_ASSOC);
    }

    public function create(array $data)
    {
        $columns = implode(', ', array_keys($data));
        $values = implode(', ', array_fill(0, count($data), '?'));

        $sql = "INSERT INTO {$this->table} ({$columns}) VALUES ({$values})";
        $stmt = $this->pdo()->prepare($sql);
        $stmt->execute(array_values($data));

        return $this->pdo()->lastInsertId();
    }

    public function delete($id)
    {
        $sql = "DELETE FROM {$this->table} WHERE id = ?";
        $stmt = $this->pdo()->prepare($sql);
        $stmt->execute([$id]);

        return $stmt->rowCount();
    }

    public function update($id, array $data)
    {
        $columns = '';
        foreach ($data as $key => $value) {
            $columns .= $key . ' = ?, ';
        }
        $columns = rtrim($columns, ', ');

        $sql = "UPDATE {$this->table} SET {$columns} WHERE id = ?";
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

        $sql = "SELECT {$columns} FROM {$this->table} {$where} {$order} LIMIT {$start}, {$limit}";
        $stmt = $this->pdo()->prepare($sql);
        $stmt->execute(array_values($conditions));

        return $stmt->fetchAll(\PDO::FETCH_ASSOC);
    }

    public function all()
    {
        $sql = "SELECT * FROM {$this->table}";
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

    /**
     * @return \PDO
     */
    protected function pdo()
    {
        return \App\Kernel\MysqlSingleton::getInstance()->getConnection();
    }
}
