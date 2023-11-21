<?php

namespace App\Controllers;

use App\Model\CourseModel;
use App\Model\TeacherModel;

class CourseController extends BaseController
{
    protected $menuSlug = 'course';

    public function createAction()
    {
        if (!$this->isAdmin()) {
            $this->notPermission();
        }

        if ($this->requestIsPost()) {
            // 创建课程
            $courseData = parts($_POST, ['course_name', 'teacher_id']);
            if (!empty($courseData)) {
                $courseModel = new CourseModel();
                $courseModel->create($courseData);
            }

            // 跳转
            $this->location('/course/list');
        }

        // 获取教师列表
        $teachers = (new TeacherModel())->search([], ['id' => 'DESC'], 0, PHP_INT_MAX, ['id', 'name']);

        $this->view('courseAdd', [
            'teachers' => $teachers,
        ]);
    }

    public function listAction()
    {
        if (!$this->isAdmin()) {
            $this->notPermission();
        }

        $page = $this->params['page'] ?? 1;
        $size = $this->params['size'] ?? 10;
        [$start, $limit] = perPage($page, $size);

        $courseModel = new CourseModel();
        $courseCount = $courseModel->count();

        $courses = $courseModel->search([], ['id' => 'DESC'], $start, $limit);

        $this->view('courseList', [
            'page' => $page,
            'total' => $courseCount,
            'courses' => $courses,
        ]);
    }

    public function detailAction()
    {
        $id = $this->params['id'];
        if (!$this->isAdmin()) {
            $this->notPermission();
        }

        $courseModel = new CourseModel();
        $course = $courseModel->get($id);

        $this->view('courseDetail', [
            'course' => $course,
        ]);
    }

    public function editAction()
    {
        $id = $this->params['id'];
        if (!$this->isAdmin()) {
            $this->notPermission();
        }

        $courseModel = new CourseModel();
        if ($this->requestIsPost() && $id == $_POST['id']) {
            // 修改课程
            $courseData = parts($_POST, ['course_name', 'teacher_id']);
            if (!empty($courseData)) {
                $courseModel->update($id, $courseData);
            }

            // 跳转
            $this->location('/course/list');
        }

        $course = $courseModel->get($id);
        // 获取教师列表
        $teachers = (new TeacherModel())->search([], ['id' => 'DESC'], 0, PHP_INT_MAX, ['id', 'name']);

        $this->view('courseEdit', [
            'teachers' => $teachers,
            'course' => $course,
        ]);
    }

    public function deleteAction()
    {
        $id = $this->params['id'];

        $this->canDelete();

        if (!$this->isAdmin()) {
            $this->notPermission();
        }

        $courseModel = new CourseModel();
        $courseModel->delete($id);

        // 跳转
        $this->location('/course/list');
    }
}
