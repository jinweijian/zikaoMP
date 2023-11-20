<?php

namespace App\Controllers;

use App\Model\ClassModel;
use App\Model\TeacherModel;

class ClassController extends BaseController
{
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

        $totalPage = ceil($classCount / $size);

        $classes = $classModel->search([], ['id' => 'DESC',], $start, $limit);

        $this->view('classList', [
            'page' => $page,
            'totalPage' => $totalPage,
            'classes' => $classes,
        ]);
    }
}