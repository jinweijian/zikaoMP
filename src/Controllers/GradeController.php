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

        $grades = $gradeModel->search([], ['id' => 'DESC'], $start, $limit);

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
        $courseModel = new CourseModel();
        $studentModel = new StudentModel();

        $grade = $gradeModel->get($id);
        $course = $courseModel->get($grade['course_id']);
        $student = $studentModel->get($grade['student_id']);

        $this->view('gradeDetail', [
            'grade' => $grade,
            'course' => $course,
            'student' => $student,
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
            $grade = parts($_POST, ['score']);
            if (!empty($grade)) {
                $gradeModel->update($id, $grade);
            }
            // 跳转
            $this->location('/grade/list');
        }
        $grade = $gradeModel->get($id);

        $this->view('gradeEdit', [
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
}
