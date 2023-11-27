<?php

namespace App\Model;

class StudentModel extends BaseModel
{
    public $table = 'students';
    public function getStudentWithClassByTeacherId($teacherId, $start = 0, $size = 10)
    {
        $where = '';
        if ($teacherId != 'admin') {
            $where = 'AND c.teacher_id = ?';
        }
        $sql = "SELECT s.*, c.class_name FROM students s 
    JOIN classes c on s.class_id = c.id 
    WHERE 1 = 1 {$where} ORDER BY s.id DESC LIMIT {$start}, {$size}";
        $studentStatement = $this->executePDO($sql, [$teacherId]);
        if ($studentStatement === false) {
            return [];
        }
        return $studentStatement->fetchAll(\PDO::FETCH_ASSOC);
    }

    public function findByUserId($userId)
    {
        $sql = "SELECT * FROM {$this->table} WHERE user_id = ?";
        $stmt = $this->pdo()->prepare($sql);
        $stmt->execute([$userId]);

        return $stmt->fetch(\PDO::FETCH_ASSOC);
    }

    public function getStudentCountByTeacherId($teacherId) {
        $where = '';
        if ($teacherId != 'admin') {
            $where = 'AND c.teacher_id = ?';
        }
        $sql = "SELECT count(s.id) as total FROM students s 
    JOIN classes c on s.class_id = c.id 
    WHERE 1 = 1 {$where}";
        $studentStatement = $this->executePDO($sql, [$teacherId]);
        if ($studentStatement === false) {
            return [];
        }
        $totalInfo = $studentStatement->fetch(\PDO::FETCH_ASSOC);

        return $totalInfo['total'] ?? 0;
    }

    public function countByClassId($classId)
    {
        $where = '';
        if ($classId != 'admin') {
            $where = 'AND class_id = ?';
        }
        $sql = "SELECT count(1) as total FROM {$this->table} WHERE 1=1 {$where}";
        $studentStatement = $this->executePDO($sql, [$classId]);
        if ($studentStatement === false) {
            return [];
        }
        $totalInfo = $studentStatement->fetch(\PDO::FETCH_ASSOC);

        return $totalInfo['total'] ?? 0;
    }
}
