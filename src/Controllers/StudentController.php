<?php

namespace App\Controllers;

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

        $studentCount = 101;
        $totalPage = ceil($studentCount / $size);

        $this->view('studentList', [
            'page' => $page,
            'totalPage' => $totalPage,
            'students' => [
                [
                    'id' => '9999',
                    'name' => 'Student',
                    'gender' => '男',
                    'dob' => '2023-10-19'
                ]
            ]
        ]);
    }

    public function get($id)
    {
        echo "Get student with ID: $id";
    }

    public function create()
    {
        echo "Create a new student";
    }

    public function update()
    {
        echo "Update a student";
    }
}