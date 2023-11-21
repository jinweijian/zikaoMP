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

    public function findClassWithTeacherByTeacherId($teacherId, $start = 0, $limit = 10)
    {
        $where = '';
        if ($teacherId != 'admin') {
            $where = 'AND teacher_id = ?';
        }
        $sql = "SELECT c.id, c.class_name, t.name as teacher_name FROM classes as c 
    LEFT JOIN teachers t on c.teacher_id = t.id 
    WHERE 1 = 1 {$where} 
    ORDER BY id DESC LIMIT {$start}, {$limit}";
        $studentStatement = $this->executePDO($sql, [$teacherId]);
        if ($studentStatement === false) {
            return [];
        }
        return $studentStatement->fetchAll(\PDO::FETCH_ASSOC);
    }

    public function countByTeacherId($teacherId)
    {
        $where = '';
        if ($teacherId != 'admin') {
            $where = 'AND teacher_id = ?';
        }
        $sql = "SELECT count(1) as total FROM {$this->table} WHERE 1=1 {$where}";
        $studentStatement = $this->executePDO($sql, [$teacherId]);
        if ($studentStatement === false) {
            return [];
        }
        $totalInfo = $studentStatement->fetch(\PDO::FETCH_ASSOC);

        return $totalInfo['total'] ?? 0;
    }
}