<?php

namespace App\Model;

class TeacherModel extends BaseModel
{
    public $table = 'teachers';

    public function findByUserId($userId)
    {
        $sql = "SELECT * FROM {$this->table} WHERE user_id = ?";
        $stmt = $this->pdo()->prepare($sql);
        $stmt->execute([$userId]);

        return $stmt->fetch(\PDO::FETCH_ASSOC);
    }
}