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
        if (!$this->isTeacher()) {
            $this->notPermission();
        }
        $name = $this->params['name'] ?? '';

        $page = $this->params['page'] ?? 1;
        $size = $this->params['size'] ?? 10;
        [$start, $limit] = perPage($page, $size);

        $teacherId = 'admin';
        if (!$this->isAdmin()) {
            $teacherInfo = $this->getTeacherInfo();
            $teacherId = $teacherInfo['id'] ?? -1;
        }

        $gradeModel = new GradeModel();
        $gradeCount = $gradeModel->countGrades($teacherId, $name);

        $grades = $gradeModel->getGrades($teacherId, $name, $start, $limit);

        $this->view('gradeList', [
            'page' => $page,
            'total' => $gradeCount,
            'grades' => $grades,
        ]);
    }

    public function detailAction()
    {
        $id = $this->params['id'];
        if (!$this->isTeacher()) {
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
        if (!$this->isTeacher()) {
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
        $this->canDelete();
        if (!$this->isTeacher()) {
            $this->notPermission();
        }

        $gradeModel = new GradeModel();
        $gradeModel->delete($id);
        // 跳转
        $this->location('/grade/list');
    }

    public function createAction()
    {
        if (!$this->isTeacher()) {
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

        $teacherId = 'admin';
        if (!$this->isAdmin()) {
            $teacherInfo = $this->getTeacherInfo();
            $teacherId = $teacherInfo['id'] ?? -1;
        }

        $courseModel = new CourseModel();
        $courses = $courseModel->getCoursesByTeacherId($teacherId);

        $this->view('gradeAdd', [
            'courses' => $courses,
        ]);
    }

    public function getStudentsAction()
    {
        $courseId = $_POST['course_id'] ?? null;
        if (empty($courseId) || !$this->isTeacher()) {
            echo json_encode([]);
            exit;
        }
        $courseModel = new CourseModel();
        $students = $courseModel->getStudentByCourseId($courseId);

        echo json_encode($students);
        exit();
    }

}
