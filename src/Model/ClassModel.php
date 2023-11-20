<?php

namespace App\Model;

class ClassModel extends BaseModel
{
    public $table = 'classes';

    public function findClassByTeacherId($teacherId)
    {
        $where = '';
        if ($teacherId != 'admin') {
            $where = 'AND teacher_id = ?';
        }
        $sql = "SELECT id, class_name FROM classes WHERE 1 = 1 {$where} ORDER BY id DESC";
        $studentStatement = $this->executePDO($sql, [$teacherId]);
        if ($studentStatement === false) {
            return [];
        }
        return $studentStatement->fetchAll(\PDO::FETCH_ASSOC);
    }
}