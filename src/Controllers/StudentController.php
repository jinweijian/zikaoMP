<?php

namespace App\Controllers;

use App\Model\ClassModel;
use App\Model\StudentModel;

class StudentController extends BaseController
{
    public function listAction()
    {
        if (!$this->isTeacher()) {
            $this->notPermission();
        }

        $page = $this->params['page'] ?? 1;
        $size = $this->params['size'] ?? 10;
        [$start, $limit] = perPage($page, $size);

        $studentModel = new StudentModel();

        $studentCount = $studentModel->count();

        $totalPage = ceil($studentCount / $size);

        $students = $studentModel->search([], ['id' => 'DESC',], $start, $limit);

        $this->view('studentList', [
            'page' => $page,
            'totalPage' => $totalPage,
            'students' => $students
        ]);
    }

    public function get($id)
    {
        echo "Get student with ID: $id";
    }

    public function createAction()
    {
        if (!$this->isTeacher()) {
            $this->notPermission();
        }
        if ($this->requestIsPost()) {
            // 创建
            $student = parts($_POST, [
                'user_id', 'name', 'dob', 'gender', 'address', 'class_id', 'card_id', 'phone_number',
            ]);
            if (!empty($student)) {
                $studentModel = new StudentModel();
                $studentModel->create($student);
            }
            // 跳转
            $this->location('/student/list');
        }
        $classService = new ClassModel();
        if ($this->isAdmin()) {
            $teacherId = 'admin';
        } else {
            $teacherInfo = $this->getTeacherInfo();
            $teacherId = $teacherInfo['id'] ?? -1;
        }
        $classes = $classService->findClassByTeacherId($teacherId);

        $this->view('studentAdd', [
            'classes' => $classes,
        ]);
    }

    public function update()
    {
        echo "Update a student";
    }
}