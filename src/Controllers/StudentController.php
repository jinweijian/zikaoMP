<?php

namespace App\Controllers;

use App\Model\ClassModel;
use App\Model\StudentCourseModel;
use App\Model\StudentModel;
use App\Model\TeacherModel;

class StudentController extends BaseController
{
    protected $menuSlug = 'student';
    public function listAction()
    {
        if (!$this->isTeacher()) {
            $this->notPermission();
        }
        $name = $this->params['name'] ?? '';

        $page = $this->params['page'] ?? 1;
        $size = $this->params['size'] ?? 10;
        [$start, $limit] = perPage($page, $size);

        $studentModel = new StudentModel();


        $teacherId = $this->getTeacherInfo()['id'] ?? 0;
        if ($this->isAdmin()) {
            $teacherId = 'admin';
        }
        $studentCount = $studentModel->countStudentWithClassByTeacherId($teacherId, $name);

        $students = $studentModel->getStudentWithClassByTeacherId($teacherId, $name, $start, $limit);

        $this->view('studentList', [
            'page' => $page,
            'total' => $studentCount,
            'students' => $students
        ]);
    }

    public function detailAction()
    {
        $id = $this->params['id'];
        if (!$this->isTeacher()) {
            $this->notPermission();
        }
        // TODO 教师只能查看自己班级的学生

        $studentModel = new StudentModel();
        $classModel = new ClassModel();
        $teacherModel = new TeacherModel();
        $student = $studentModel->get($id);
        $class = $classModel->get($student['class_id'] ?? -1);
        $teacher = $teacherModel->get($class['teacher_id'] ?? -1);

        $enrolledCourses = (new StudentCourseModel())->getStudentEnrollmentCourses($id);

        $this->view('studentDetail', [
            'student' => $student,
            'class' => $class,
            'teacher' => $teacher,
            'enrolledCourses' => $enrolledCourses,
        ]);
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

    public function editAction()
    {
        $id = $this->params['id'];
        if (!$this->isTeacher()) {
            $this->notPermission();
        }
        // TODO 教师只能查看自己班级的学生

        if ($this->requestIsPost() && $id == ($_POST['id'] ?? -1)) {
            // 创建
            $student = parts($_POST, [
                'user_id', 'name', 'dob', 'gender', 'address', 'class_id', 'card_id', 'phone_number',
            ]);
            if (!empty($student)) {
                $studentModel = new StudentModel();
                $studentModel->update($id, $student);
            }
            // 跳转
            $this->location('/student/list');
        }
        $studentModel = new StudentModel();
        $student = $studentModel->get($id);
        $classService = new ClassModel();
        if ($this->isAdmin()) {
            $teacherId = 'admin';
        } else {
            $teacherInfo = $this->getTeacherInfo();
            $teacherId = $teacherInfo['id'] ?? -1;
        }
        $classes = $classService->findClassByTeacherId($teacherId);
        $this->view('studentEdit', [
            'student' => $student,
            'classes' => $classes,
        ]);
    }

    public function deleteAction()
    {
        $id = $this->params['id'];
        if (!$this->isTeacher()) {
            $this->notPermission();
        }
        // TODO 教师只能查看自己班级的学生

        $studentModel = new StudentModel();
        $studentModel->delete($id);
        // 跳转
        $this->location('/student/list');
    }
}