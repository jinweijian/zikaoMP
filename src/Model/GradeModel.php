<?php

namespace App\Model;

class GradeModel extends BaseModel
{
    public $table = 'grades';

    public function getGrades($start, $limit)
    {
        $sql = "SELECT g.id, s.name as student_name, c.course_name, g.score FROM grades g 
    LEFT JOIN students s on s.id = g.student_id
    LEFT JOIN courses c on c.id = g.course_id
    ORDER BY g.id DESC LIMIT {$start}, $limit";
        $stmt = $this->pdo()->prepare($sql);
        $stmt->execute();

        // 获取查询结果
        return $stmt->fetchAll(\PDO::FETCH_ASSOC);
    }
}