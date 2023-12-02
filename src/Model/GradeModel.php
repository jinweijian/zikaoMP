<?php

namespace App\Model;

class GradeModel extends BaseModel
{
    public $table = 'grades';

    public function getGrades($teacherId, $name, $start, $limit)
    {
        $where = '';
        $params = [];
        if ($teacherId != 'admin') {
            $where = ' AND c.teacher_id = ?';
            $params[] = $teacherId;
        }
        if (!empty($name)) {
            $where = ' AND s.name like ? ';
            $params[] = "%{$name}%";
        }
        $sql = "SELECT g.id, s.name as student_name, c.course_name, g.score FROM grades g 
    LEFT JOIN students s on s.id = g.student_id
    LEFT JOIN courses c on c.id = g.course_id
    WHERE 1=1 {$where}
    ORDER BY g.id DESC LIMIT {$start}, {$limit}";
        $stmt = $this->executePDO($sql, $params);

        // 获取查询结果
        return $stmt->fetchAll(\PDO::FETCH_ASSOC);
    }

    public function countGrades($teacherId, $name)
    {
        $where = '';
        $params = [];
        if ($teacherId != 'admin') {
            $where = ' AND c.teacher_id = ?';
            $params[] = $teacherId;
        }
        if (!empty($name)) {
            $where = ' AND s.name like ? ';
            $params[] = "%{$name}%";
        }
        $sql = "SELECT count(g.id) as total FROM grades g 
    LEFT JOIN students s on s.id = g.student_id
    LEFT JOIN courses c on c.id = g.course_id
    WHERE 1=1 {$where}";
        $stmt = $this->executePDO($sql, $params);

        // 获取查询结果
        $totalInfo = $stmt->fetch(\PDO::FETCH_ASSOC);

        return $totalInfo['total'] ?? 0;
    }
}