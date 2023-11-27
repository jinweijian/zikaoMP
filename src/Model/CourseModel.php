<?php

namespace App\Model;

class CourseModel extends BaseModel
{
    public $table = 'courses';


    /**
     * 根据学生ID获取关联的课程列表
     *
     * @param int $studentId
     * @return array
     */
    public function getCoursesByStudentId(int $studentId): array
    {
        // 使用 PDO 执行查询
        $sql = "SELECT c.id, c.course_name FROM student_course_relation scr 
                INNER JOIN courses as c ON c.id = scr.course_id
                WHERE scr.student_id = :studentId";
        $stmt = $this->pdo()->prepare($sql);
        $stmt->bindParam(':studentId', $studentId, \PDO::PARAM_INT);
        $stmt->execute();

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
}