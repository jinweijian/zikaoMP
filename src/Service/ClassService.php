<?php

namespace App\Service;

use App\Model\ClassModel;

class ClassService
{
    public function getClassesByTeacherId($teacherId, $start = 0, $limit = 10)
    {
        $classModel = new ClassModel();
        return $classModel->search(['teacher_id' => $teacherId], ['id' => 'DESC'], $start, $limit);
    }
}