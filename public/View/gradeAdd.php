<!DOCTYPE html>
<html lang="zh-CN">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>录入学生成绩</title>
    <link rel="stylesheet" href="https://stackpath.bootstrapcdn.com/bootstrap/4.5.2/css/bootstrap.min.css">
    <script src="https://code.jquery.com/jquery-3.5.1.min.js"></script>
</head>
<body>

<div class="container mt-4">

    <?php echo getHeard($user); ?>

    <div class="row mt-3">
        <?php echo getNavbar($user, $menuSlug); ?>

        <div class="col-md-9">
            <h1>录入学生成绩</h1>

            <!-- 使用学生和课程联动表单 -->
            <form id="gradeForm" method="post" action="/grade/create">
                <label for="studentId">选择学生：</label>
                <select id="studentId" name="student_id">
                    <option value="">请选择学生</option>
                    <?php foreach ($students as $student): ?>
                        <option value="<?php echo $student['id']; ?>"><?php echo $student['name']; ?></option>
                    <?php endforeach; ?>
                </select>

                <label for="courseId">选择课程：</label>
                <select id="courseId" name="course_id">
                    <!-- 这里的选项将通过 Ajax 动态加载 -->
                </select>

                <label for="score">分数：</label>
                <input type="text" id="score" name="score" required>

                <button type="submit" class="btn btn-primary">提交</button>
            </form>

            <!-- 返回按钮 -->
            <a href="/grade/list" class="btn btn-secondary mt-3">返回学生成绩列表</a>
        </div>
    </div>
</div>

<script src="https://cdn.jsdelivr.net/npm/@popperjs/core@2.11.6/dist/umd/popper.min.js"></script>
<script src="https://stackpath.bootstrapcdn.com/bootstrap/4.5.2/js/bootstrap.min.js"></script>

<script>
    $('#studentId').on('change', function() {
        var studentId = $(this).val();

        // 发送 Ajax 请求获取课程列表
        $.ajax({
            url: '/grade/getCourses',
            type: 'post',
            data: { student_id: studentId },
            dataType: 'json',
            success: function(data) {
                // 清空课程选择框
                $('#courseId').empty();

                // 添加新的课程选项
                $.each(data, function(index, course) {
                    $('#courseId').append('<option value="' + course.id + '">' + course.course_name + '</option>');
                });
            }
        });
    });
</script>

</body>
</html>
