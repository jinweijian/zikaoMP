<!DOCTYPE html>
<html lang="zh-CN">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>编辑成绩</title>
    <link rel="stylesheet" href="https://stackpath.bootstrapcdn.com/bootstrap/4.5.2/css/bootstrap.min.css">
</head>
<body>

<div class="container mt-4">

    <?php echo getNavbar($user, $menuSlug); ?>

    <div class="row mt-3">
        <div class="col-md-9">
            <h1>编辑成绩</h1>
            <form action="/grade/edit?id=<?php echo $grade['id']; ?>" method="post">
                <div class="form-group">
                    <label for="student_id">学生</label>
                    <select class="form-control" id="student_id" name="student_id" required>
                        <?php foreach ($students as $student): ?>
                            <option value="<?php echo $student['id']; ?>"
                                <?php if ($student['id'] == $grade['student_id']) echo 'selected'; ?>>
                                <?php echo $student['name']; ?>
                            </option>
                        <?php endforeach; ?>
                    </select>
                </div>
                <div class="form-group">
                    <label for="course_id">课程</label>
                    <select class="form-control" id="course_id" name="course_id" required>
                        <?php foreach ($courses as $course): ?>
                            <option value="<?php echo $course['id']; ?>"
                                <?php if ($course['id'] == $grade['course_id']) echo 'selected'; ?>>
                                <?php echo $course['name']; ?>
                            </option>
                        <?php endforeach; ?>
                    </select>
                </div>
                <div class="form-group">
                    <label for="score">分数</label>
                    <input type="number" class="form-control" id="score" name="score" value="<?php echo $grade['score']; ?>" required>
                </div>
