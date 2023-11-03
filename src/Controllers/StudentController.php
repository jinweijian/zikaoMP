<?php

namespace App\Controllers;

class StudentController
{
    public function lists()
    {
        echo "List all students";
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