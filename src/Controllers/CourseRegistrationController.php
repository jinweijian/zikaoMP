<?php

namespace App\Controllers;

use App\Model\CourseModel;
use App\Model\StudentCourseModel;

class CourseRegistrationController extends BaseController
{

    protected $menuSlug = 'courseRegistration';
    public function enrollAction()
    {
        // 获取当前学生的 ID
        $studentId = $this->getCurrentStudentId();
        if (empty($studentId)) {
            header("HTTP/1.0 400 ");
            echo "400 您不是学员，无法操作选课";
            exit();
        }
        // 如果是 POST 请求，处理选课逻辑
        if ($this->requestIsPost()) {
            $selectedCourses = $_POST['courses'] ?? [];


            // 检查学生选课数量是否超过限制
            if (count($selectedCourses) >= 3 || $this->studentCanEnrolled($studentId)) {
                $this->location('/courseRegistration/enroll?error=1');
            }

            // 遍历选中的课程进行报名
            foreach ($selectedCourses as $courseId) {
                if ($this->studentCanEnrolled($studentId)) {
                    $this->location('/courseRegistration/enroll?error=1');
                }
                // 检查课程是否已经达到选修人数上限
                if (!$this->isCourseAvailable($courseId)) {
                    $this->location('/courseRegistration/enroll?error=2');
                }

                // 检查是否已经报名该课程，如果未报名则进行报名
                if (!$this->isStudentEnrolled($studentId, $courseId)) {
                    $this->enrollStudentInCourse($studentId, $courseId);
                }
            }

            // 跳转或返回成功信息
            $this->location('/courseRegistration/enroll');
        }

        $enrolledCourses = (new StudentCourseModel())->getStudentEnrollmentCourses($studentId);
        // 获取所有可选课程
        $courseModel = new CourseModel();
        $courses = $courseModel->getCoursesByNotIds(array_column($enrolledCourses, 'course_id'));

        // 渲染选课页面
        $this->view('studentCourseEnroll', [
            'courses' => $courses,
            'enrolledCourses' => $enrolledCourses,
        ]);
    }

    public function deleteAction()
    {
        $id = $this->params['id'];
        $courseId = $this->params['course_id'];

        $this->canDelete();

        if (!$this->isTeacher()) {
            $this->notPermission();
        }

        $model = new StudentCourseModel();
        $model->delete($id);

        // 刷新页面
        $this->location("/course/detail?id={$courseId}");
    }


    // 检查课程是否可选
    private function isCourseAvailable($courseId)
    {
        $studentCourseModel = new StudentCourseModel();
        $enrollmentCount = $studentCourseModel->getEnrollmentCount($courseId);

        // 假设课程上限为30人
        return $enrollmentCount < 30;
    }


    // 获取当前学生的 ID
    private function getCurrentStudentId()
    {
        $student = $this->getStudentInfo();
        return $student['id'] ?? -1;
    }

    // 判断学生是否已经报名某课程
    private function isStudentEnrolled($studentId, $courseId)
    {
        $studentCourseModel = new StudentCourseModel();
        return $studentCourseModel->isEnrolled($studentId, $courseId);
    }

    private function studentCanEnrolled($studentId) : bool
    {
        $studentCourseModel = new StudentCourseModel();
        $enrolledCount = $studentCourseModel->countStudentEnrolled($studentId);

        return $enrolledCount >= 3;
    }

    // 报名学生到课程
    private function enrollStudentInCourse($studentId, $courseId)
    {
        $studentCourseModel = new StudentCourseModel();
        $studentCourseModel->enrollStudent($studentId, $courseId);
    }


}
