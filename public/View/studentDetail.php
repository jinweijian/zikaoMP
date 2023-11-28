<!DOCTYPE html>
<html lang="zh-CN">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>学生详情</title>
    <link rel="stylesheet" href="https://stackpath.bootstrapcdn.com/bootstrap/4.5.2/css/bootstrap.min.css">
</head>
<body>

<div class="container mt-4">
    <?php echo getHeard($user); ?>

    <div class="row mt-3">
        <?php echo getNavbar($user, $menuSlug); ?>

        <div class="col-md-9">
            <h1>学生详情</h1>
            <ul class="list-group">
                <li class="list-group-item"><strong>ID:</strong> <?php echo $student['id']; ?></li>
                <li class="list-group-item"><strong>姓名:</strong> <?php echo $student['name']; ?></li>
                <li class="list-group-item"><strong>性别:</strong> <?php $student['gender'] == 'male' ? $gender = '男' : $gender = '女'; echo $gender; ?></li>
                <li class="list-group-item"><strong>出生日期:</strong> <?php echo $student['dob']; ?></li>
                <li class="list-group-item"><strong>家庭住址:</strong> <?php echo $student['address']; ?></li>
                <li class="list-group-item"><strong>身份证号码:</strong> <?php echo $student['card_id']; ?></li>
                <li class="list-group-item"><strong>班级:</strong><a href="/class/detail?id=<?php echo $class['id'];?>"> <?php echo $class['class_name']; ?></a></li>
                <li class="list-group-item"><strong>成绩总分:</strong> <?php echo $student['total_score']; ?></li>
                <li class="list-group-item"><strong>辅导员:</strong><a href="/teacher/detail?id=<?php echo $teacher['id'];?>"> <?php echo $teacher['name']; ?></a></li>
                <li class="list-group-item"><strong>辅导员联系电话:</strong><?php echo $teacher['phone_number']; ?></li>
            </ul>

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
