<?php

namespace App\Controllers;

use App\Model\ClassModel;
use App\Model\StudentModel;
use App\Model\TeacherModel;

class ClassController extends BaseController
{
    protected $menuSlug = 'class';
    public function createAction()
    {
        if (!$this->isAdmin()) {
            $this->notPermission();
        }
        if ($this->requestIsPost()) {
            // 创建
            $class = parts($_POST, ['class_name', 'teacher_id']);
            if (!empty($class)) {
                $classModel = new ClassModel();
                $classModel->create($class);
            }
            // 跳转
            $this->location('/class/list');
        }
        // 教师列表
        $teachers = (new TeacherModel())->search([], ['id' => 'DESC'], 0, PHP_INT_MAX, ['id', 'name']);
        $this->view('classAdd', [
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

        $classModel = new ClassModel();
        $classCount = $classModel->count();

        $teacherInfo = $this->getTeacherInfo();
        $teacherId = $teacherInfo['id'] ?? -1;

        if ($this->isAdmin()) {
            $teacherId = 'admin';
        }

        $classes = $classModel->findClassWithTeacherByTeacherId($teacherId, $start, $limit);

        $this->view('classList', [
            'page' => $page,
            'total' => $classCount,
            'classes' => $classes,
        ]);
    }

    public function detailAction()
    {
        $id = $this->params['id'];
        if (!$this->isTeacher()) {
            $this->notPermission();
        }
        // TODO 教师只能查看自己管理的班级

        $page = $this->params['page'] ?? 1;
        $size = $this->params['size'] ?? 10;
        [$start, $limit] = perPage($page, $size);

        $classModel = new ClassModel();
        $studentModel = new StudentModel();
        $class = $classModel->get($id);

        $students = $studentModel->search(['class_id' => $id], ['id' => 'DESC'], $start, $limit);

        $studentCount = $studentModel->countByClassId($id);

        $this->view('classDetail', [
            'class' => $class,
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
        $classModel = new ClassModel();
        if ($this->requestIsPost() && $id == $_POST['id']) {
            // 修改
            $class = parts($_POST, ['class_name', 'teacher_id']);
            if (!empty($class)) {
                $classModel->update($id, $class);
            }
            // 跳转
            $this->location('/class/list');
        }
        $class = $classModel->get($id);
        // 教师列表
        $teachers = (new TeacherModel())->search([], ['id' => 'DESC'], 0, PHP_INT_MAX, ['id', 'name']);
        $this->view('classEdit', [
            'teachers' => $teachers,
            'class' => $class,
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
        if (!$this->isTeacher()) {
            $this->notPermission();
        }
        // TODO 教师只能查看自己管理的班级

        $classModel = new ClassModel();
        $classModel->delete($id);
        // 跳转
        $this->location('/class/list');
    }
}