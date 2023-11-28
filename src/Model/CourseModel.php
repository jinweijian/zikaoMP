<?php

namespace App\Model;

class CourseModel extends BaseModel
{
    public $table = 'courses';

    public function getCoursesByTeacherId($teacherId): array
    {
        $where = '';
        $params = [];
        if (!empty($teacherId) && $teacherId != 'admin') {
            $where = " AND c.teacher_id = ?";
            $params[] = $teacherId;
        }
        $sql = "SELECT c.id, c.course_name FROM courses as c 
                WHERE 1=1 {$where}";
        $stmt = $this->executePDO($sql, $params);

        // 获取查询结果
        return $stmt->fetchAll(\PDO::FETCH_ASSOC);
    }

    public function getStudentByCourseId($courseId): array
    {
        $params = [$courseId];
        $sql = "SELECT DISTINCT s.id, s.name as student_name FROM students as s  
                LEFT JOIN student_course_relation scr ON s.id = scr.student_id
                WHERE scr.course_id = ? ";
        $stmt = $this->executePDO($sql, $params);

        // 获取查询结果
        return $stmt->fetchAll(\PDO::FETCH_ASSOC);
    }

    public function getCoursesByNotIds($courseIds)
    {
        if (empty($courseIds)) {
            $courseIds = [-1, 0];
        }

        $placeholders = implode(', ', array_fill(0, count($courseIds), '?'));

        $sql = "SELECT * FROM {$this->table} WHERE id NOT IN ({$placeholders})";
        $stmt = $this->executePDO($sql, $courseIds);

        return $stmt->fetchAll(\PDO::FETCH_ASSOC);
    }

    public function findCourseWithStudentCountByTeacherId($teacherId, $start, $limit)
    {
        $where = '';
        $params = [];
        if (!empty($teacherId) && $teacherId != 'admin') {
            $where = " AND c.teacher_id = ?";
            $params[] = $teacherId;
        }
        $sql = "SELECT c.*, COUNT(scr.student_id) as total, t.name as teacher_name FROM `courses` as c 
    LEFT JOIN `student_course_relation` as scr ON scr.course_id = c.id 
    LEFT JOIN `teachers` as t ON t.id = c.teacher_id 
    WHERE 1=1 {$where}
    GROUP BY c.id ORDER BY c.id DESC LIMIT {$start}, {$limit}";

        $stmt = $this->executePDO($sql, $params);

        return $stmt->fetchAll(\PDO::FETCH_ASSOC);

    }

    public function getCourseStudentsByCourseId($courseId, $start, $limit)
    {
        $sql = "SELECT scr.id as enroll_id, s.name as student_name, scr.created_time as enroll_time FROM `student_course_relation` as scr 
    LEFT JOIN `courses` as c ON scr.course_id = c.id 
    LEFT JOIN `students` as s ON scr.student_id = s.id
    WHERE scr.course_id = ? 
    ORDER BY scr.id DESC LIMIT {$start}, {$limit}";
        $stmt = $this->executePDO($sql, [$courseId]);

        return $stmt->fetchAll(\PDO::FETCH_ASSOC);
    }

    public function countStudentByCourseId($courseId)
    {
        $sql = "SELECT COUNT(1) as `total` FROM `student_course_relation` WHERE course_id = ?";
        $stmt = $this->executePDO($sql, [$courseId]);

        $totalInfo = $stmt->fetch(\PDO::FETCH_ASSOC);

        return $totalInfo['total'] ?? 0;
    }
}