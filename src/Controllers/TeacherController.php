<?php

namespace App\Controllers;

use App\Model\ClassModel;
use App\Model\TeacherModel;

class TeacherController extends BaseController
{
    public function createAction()
    {
        if (!$this->isAdmin()) {
            $this->notPermission();
        }
        if ($this->requestIsPost()) {
            // 创建
            $teacher = parts($_POST, ['name', 'card_id', 'phone_number']);
            if (!empty($teacher)) {
                $teacherModel = new TeacherModel();
                $teacherModel->create($teacher);
            }
            // 跳转
            $this->location('/teacher/list');
        }
        $this->view('teacherAdd');
    }

    public function listAction()
    {
        if (!$this->isAdmin()) {
            $this->notPermission();
        }

        $page = $this->params['page'] ?? 1;
        $size = $this->params['size'] ?? 10;
        [$start, $limit] = perPage($page, $size);

        $teacherModel = new TeacherModel();
        $teacherCount = $teacherModel->count();

        $teachers = $teacherModel->search([], ['id' => 'DESC',], $start, $limit);

        $this->view('teacherList', [
            'page' => $page,
            'total' => $teacherCount,
            'teachers' => $teachers,
        ]);
    }

    public function detailAction()
    {
        $id = $this->params['id'];
        if (!$this->isAdmin()) {
            $this->notPermission();
        }

        $page = $this->params['page'] ?? 1;
        $size = $this->params['size'] ?? 10;
        [$start, $limit] = perPage($page, $size);

        $classModel = new ClassModel();
        $teacherModel = new TeacherModel();
        $teacher = $teacherModel->get($id);

        $classes = $classModel->search(['teacher_id' => $id], ['id' => 'DESC'], $start, $limit);

        $teacherCount = $classModel->countByTeacherId($id);

        $this->view('teacherDetail', [
            'classes' => $classes,
            'teacher' => $teacher,
            'page' => $page,
            'classTotal' => $teacherCount,
        ]);
    }

    public function editAction()
    {
        $id = $this->params['id'];
        if (!$this->isAdmin()) {
            $this->notPermission();
        }

        if ($this->requestIsPost() && $id == ($_POST['id'] ?? -1)) {
            // 创建
            $teacher = parts($_POST, [
                'name', 'card_id', 'phone_number'
            ]);
            if (!empty($teacher)) {
                $teacherModel = new TeacherModel();
                $teacherModel->update($id, $teacher);
            }
            // 跳转
            $this->location('/teacher/list');
        }
        $teacherModel = new TeacherModel();
        $teacher = $teacherModel->get($id);

        $this->view('teacherEdit', [
            'teacher' => $teacher,
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

        $teacherModel = new TeacherModel();
        $teacherModel->delete($id);
        // 跳转
        $this->location('/teacher/list');
    }
}