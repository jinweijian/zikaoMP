<!DOCTYPE html>
<html lang="zh-CN">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>学生选课</title>
    <link rel="stylesheet" href="https://stackpath.bootstrapcdn.com/bootstrap/4.5.2/css/bootstrap.min.css">
</head>
<body>

<div class="container mt-4">

    <?php echo getHeard($user); ?>

    <div class="row mt-3">
        <?php echo getNavbar($user, $menuSlug); ?>

        <div class="col-md-9">
            <!-- 登录失败提示 -->
            <?php if (isset($_GET['error']) && $_GET['error'] == 1) : ?>
                <div class="alert alert-danger" role="alert">
                    选课失败，最多只能选择3门课程
                </div>
            <?php endif; ?>

            <?php if (isset($_GET['error']) && $_GET['error'] == 2) : ?>
                <div class="alert alert-danger" role="alert">
                    选课失败，课程选课人数已满
                </div>
            <?php endif; ?>

            <h1>选课报名</h1>
            <form method="post" action="/courseRegistration/enroll">
                <?php foreach ($courses as $course): ?>
                    <div class="form-check">
                        <input class="form-check-input" type="checkbox" name="courses[]" value="<?php echo $course['id']; ?>">
                        <label class="form-check-label"><?php echo $course['course_name']; ?></label>
                    </div>
                <?php endforeach; ?>
                <button type="submit" class="btn btn-primary mt-3">提交选课</button>
            </form>

            <!-- 已选课程列表 -->
            <h2>已选课程列表</h2>
            <table class="table table-bordered table-hover">
                <thead>
                <tr>
                    <th>ID</th>
                    <th>课程名称</th>
                    <th>教师姓名</th>
                    <th>已选修人数</th>
                </tr>
                </thead>
                <tbody>
                <?php foreach ($enrolledCourses as $course): ?>
                    <tr>
                        <td><?php echo $course['course_id']; ?></td>
                        <td><?php echo $course['course_name']; ?></td>
                        <td><?php echo $course['teacher_name']; ?></td>
                        <td><?php echo $course['enrollment_count']; ?></td>
                    </tr>
                <?php endforeach; ?>
                </tbody>
            </table>

        </div>
    </div>
</div>

<script src="https://code.jquery.com/jquery-3.5.1.slim.min.js"></script>
<script src="https://cdn.jsdelivr.net/npm/@popperjs/core@2.11.6/dist/umd/popper.min.js"></script>
<script src="https://stackpath.bootstrapcdn.com/bootstrap/4.5.2/js/bootstrap.min.js"></script>

</body>
</html>
