<?php

namespace App\Model;

class StudentCourseModel extends BaseModel
{
    public $table = 'student_course_relation';

    /**
     * 检查学生是否已经报名某门课程
    /**
     * @param $studentId
     * @param $courseId
     * @return bool
     */
    public function isEnrolled($studentId, $courseId): bool
    {
        $sql = "SELECT COUNT(1) as `count` FROM {$this->table} WHERE student_id = ? AND course_id = ?";
        $stmt = $this->executePDO($sql, [$studentId, $courseId]);
        $count = $stmt->fetch(\PDO::FETCH_ASSOC)['count'];

        return $count > 0;
    }

    public function countStudentEnrolled($studentId): int
    {
        $sql = "SELECT COUNT(1) as `count` FROM {$this->table} WHERE student_id = ?";
        $stmt = $this->executePDO($sql, [$studentId]);
        $count = $stmt->fetch(\PDO::FETCH_ASSOC)['count'];

        return $count;
    }

    /**
     * 学生报名课程
     * @param $studentId
     * @param $courseId
     * @return false|string
     */
    public function enrollStudent($studentId, $courseId)
    {
        // 检查学生是否已经报名，如果已经报名则直接返回
        if ($this->isEnrolled($studentId, $courseId)) {
            return false;
        }

        // 执行学生报名操作
        $data = [
            'student_id' => $studentId,
            'course_id' => $courseId,
            'created_time' => time(),
        ];

        return $this->create($data);
    }

    /**
     * 获取课程报名人数
     * @param $courseId
     * @return int|mixed
     */
    public function getEnrollmentCount($courseId)
    {
        $sql = "SELECT COUNT(*) as `enrollment_count` FROM {$this->table} WHERE course_id = ?";
        $stmt = $this->executePDO($sql, [$courseId]);
        $result = $stmt->fetch(\PDO::FETCH_ASSOC);

        return $result['enrollment_count'] ?? 0;
    }

    public function getStudentEnrollmentCourses($studentId)
    {
        $sql = "
        SELECT
            sc.id AS enrollment_id,
            sc.created_time AS enrollment_time,
            c.id AS course_id,
            c.course_name,
            t.name AS teacher_name
        FROM
            student_course_relation sc
        JOIN
            courses c ON sc.course_id = c.id
        JOIN
            teachers t ON c.teacher_id = t.id
        WHERE
            sc.student_id = ?
        GROUP BY
            sc.id, c.id, c.course_name, t.name";
        $stmt = $this->executePDO($sql, [$studentId]);

        return $stmt->fetchAll(\PDO::FETCH_ASSOC);
    }

}