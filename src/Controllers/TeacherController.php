<?php

namespace App\Controllers;

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

        $totalPage = ceil($teacherCount / $size);

        $teachers = $teacherModel->search([], ['id' => 'DESC',], $start, $limit);

        $this->view('teacherList', [
            'page' => $page,
            'totalPage' => $totalPage,
            'teachers' => $teachers,
        ]);
    }
}