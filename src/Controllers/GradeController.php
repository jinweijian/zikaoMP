<?php

namespace App\Controllers;

use App\Model\GradeModel;
use App\Model\StudentModel;
use App\Model\CourseModel;

class GradeController extends BaseController
{
    protected $menuSlug = 'grade';

    public function listAction()
    {
        if (!$this->isAdmin()) {
            $this->notPermission();
        }

        $page = $this->params['page'] ?? 1;
        $size = $this->params['size'] ?? 10;
        [$start, $limit] = perPage($page, $size);

        $gradeModel = new GradeModel();
        $gradeCount = $gradeModel->count();

        $grades = $gradeModel->getGrades($start, $limit);

        $this->view('gradeList', [
            'page' => $page,
            'total' => $gradeCount,
            'grades' => $grades,
        ]);
    }

    public function detailAction()
    {
        $id = $this->params['id'];
        if (!$this->isAdmin()) {
            $this->notPermission();
        }

        $gradeModel = new GradeModel();
        $studentModel = new StudentModel();
        $courseModel = new CourseModel();

        $grade = $gradeModel->get($id);
        $student = $studentModel->get($grade['student_id']);
        $course = $courseModel->get($grade['course_id']);

        $this->view('gradeDetail', [
            'grade' => $grade,
            'student' => $student,
            'course' => $course,
        ]);
    }

    public function editAction()
    {
        $id = $this->params['id'];
        if (!$this->isAdmin()) {
            $this->notPermission();
        }

        $gradeModel = new GradeModel();
        if ($this->requestIsPost() && $id == $_POST['id']) {
            // 修改
            $grade = parts($_POST, ['student_id', 'course_id', 'score']);
            if (!empty($grade)) {
                $gradeModel->update($id, $grade);
            }
            // 跳转
            $this->location('/grade/list');
        }

        $grade = $gradeModel->get($id);
        $students = (new StudentModel())->search([], ['id' => 'DESC'], 0, PHP_INT_MAX, ['id', 'name']);
        $courses = (new CourseModel())->search([], ['id' => 'DESC'], 0, PHP_INT_MAX, ['id', 'name']);

        $this->view('gradeEdit', [
            'students' => $students,
            'courses' => $courses,
            'grade' => $grade,
        ]);
    }

    public function deleteAction()
    {
        $id = $this->params['id'];
        $deleteTime = $this->params['timespan'] ?? 0;
        if (empty($id) || $deleteTime <= time() - 60) {
            header("HTTP/1.0 422 ");
            echo "422 参数不合法/页面已过期";
            exit();
        }
        if (!$this->isAdmin()) {
            $this->notPermission();
        }

        $gradeModel = new GradeModel();
        $gradeModel->delete($id);
        // 跳转
        $this->location('/grade/list');
    }

    public function createAction()
    {
        if (!$this->isAdmin()) {
            $this->notPermission();
        }

        if ($this->requestIsPost()) {
            // 处理表单提交
            $studentId = $_POST['student_id'] ?? null;
            $courseId = $_POST['course_id'] ?? null;
            $score = $_POST['score'] ?? null;

            if ($studentId && $courseId && $score !== null) {
                $gradeModel = new GradeModel();
                $gradeModel->create([
                    'student_id' => $studentId,
                    'course_id' => $courseId,
                    'score' => $score,
                ]);
            }

            // 跳转
            $this->location('/grade/list');
        }

        // 获取学生列表和课程列表
        $studentModel = new StudentModel();
        $students = $studentModel->search([], ['id' => 'DESC'], 0, PHP_INT_MAX, ['id', 'name']);

        $this->view('gradeAdd', [
            'students' => $students,
        ]);
    }

    public function getCoursesAction()
    {
        $studentId = $_POST['student_id'] ?? null;

        if ($studentId !== null) {
            $courseModel = new CourseModel();
            $courses = $courseModel->getCoursesByStudentId($studentId);

            echo json_encode($courses);
        }

        exit();
    }

}
