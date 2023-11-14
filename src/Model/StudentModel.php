<?php

namespace App\Model;

class StudentModel extends BaseModel
{
    public function getStudentWithClassByTeacherId($teacherId, $start = 0, $size = 10)
    {
        $sql = "SELECT s.*, c.class_name FROM students s 
    JOIN classes c on s.class_id = c.id 
    WHERE c.teacher_id = ? ORDER BY s.id DESC LIMIT {$start}, {$size}";
        $studentStatement = $this->executePDO($sql, [$teacherId]);
        if ($studentStatement === false) {
            return [];
        }
        return $studentStatement->fetchAll(\PDO::FETCH_ASSOC);
    }

    public function getStudentCountByTeacherId($teacherId) {
        $sql = "SELECT count(s.id) as total FROM students s 
    JOIN classes c on s.class_id = c.id 
    WHERE c.teacher_id = ?";
        $studentStatement = $this->executePDO($sql, [$teacherId]);
        if ($studentStatement === false) {
            return [];
        }
        $totalInfo = $studentStatement->fetch(\PDO::FETCH_ASSOC);

        return $totalInfo['total'] ?? 0;
    }
}
