<?php

namespace App\Controllers;

use App\Model\CourseModel;
use App\Model\TeacherModel;

class CourseController extends BaseController
{
    protected $menuSlug = 'course';

    public function createAction()
    {
        if (!$this->isTeacher()) {
            $this->notPermission();
        }
        $teacherId = 'admin';
        $condition = [];
        if (!$this->isAdmin()) {
            $teacherInfo = $this->getTeacherInfo();
            $teacherId = $teacherInfo['id'] ?? -1;
            $condition = ['id' => $teacherId];
        }
        if ($this->requestIsPost()) {
            // 创建选课
            $courseData = parts($_POST, ['course_name', 'teacher_id']);
            if (!empty($courseData)) {
                $courseModel = new CourseModel();
                $courseModel->create($courseData);
            }

            // 跳转
            $this->location('/course/list');
        }

        // 获取教师列表
        $teachers = (new TeacherModel())->search($condition, ['id' => 'DESC'], 0, PHP_INT_MAX, ['id', 'name']);

        $this->view('courseAdd', [
            'teachers' => $teachers,
        ]);
    }

    public function listAction()
    {
        if (!$this->isTeacher()) {
            $this->notPermission();
        }
        $teacherId = 'admin';
        if (!$this->isAdmin()) {
            $teacherInfo = $this->getTeacherInfo();
            $teacherId = $teacherInfo['id'] ?? -1;
        }

        $page = $this->params['page'] ?? 1;
        $size = $this->params['size'] ?? 10;
        [$start, $limit] = perPage($page, $size);

        $courseModel = new CourseModel();
        $courseCount = $courseModel->count();

        $courses = $courseModel->findCourseWithStudentCountByTeacherId($teacherId, $start, $limit);

        $this->view('courseList', [
            'page' => $page,
            'total' => $courseCount,
            'courses' => $courses,
        ]);
    }

    public function detailAction()
    {
        $id = $this->params['id'];
        if (!$this->isTeacher()) {
            $this->notPermission();
        }

        $courseModel = new CourseModel();
        $course = $courseModel->get($id);

        $teacherModel = new TeacherModel();
        $teacher = $teacherModel->get($course['teacher_id'] ?? -1);

        $page = $this->params['page'] ?? 1;
        $size = $this->params['size'] ?? 10;
        [$start, $limit] = perPage($page, $size);

        $students = $courseModel->getCourseStudentsByCourseId($id, $start, $limit);

        $studentCount = $courseModel->countStudentByCourseId($id);

        $this->view('courseDetail', [
            'course' => $course,
            'teacher' => $teacher,
            'students' => $students,
            'page' => $page,
            'studentTotal' => $studentCount,
        ]);
    }

    public function editAction()
    {
        $id = $this->params['id'];
        if (!$this->isTeacher()) {
            $this->notPermission();
        }

        $courseModel = new CourseModel();
        if ($this->requestIsPost() && $id == $_POST['id']) {
            // 修改选课
            $courseData = parts($_POST, ['course_name', 'teacher_id']);
            if (!empty($courseData)) {
                $courseModel->update($id, $courseData);
            }

            // 跳转
            $this->location('/course/list');
        }

        $teacherId = 'admin';
        $condition = [];
        if (!$this->isAdmin()) {
            $teacherInfo = $this->getTeacherInfo();
            $teacherId = $teacherInfo['id'] ?? -1;
            $condition = ['id' => $teacherId];
        }
        $course = $courseModel->get($id);
        // 获取教师列表
        $teachers = (new TeacherModel())->search($condition, ['id' => 'DESC'], 0, PHP_INT_MAX, ['id', 'name']);

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
