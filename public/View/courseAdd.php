<!DOCTYPE html>
<html lang="zh-CN">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>创建课程</title>
    <link rel="stylesheet" href="https://stackpath.bootstrapcdn.com/bootstrap/4.5.2/css/bootstrap.min.css">
</head>
<body>

<div class="container mt-4">
    <?php echo getHeard($user); ?>

    <div class="row mt-3">
        <?php echo getNavbar($user, $menuSlug); ?>

        <div class="col-md-9">
            <h1>创建课程</h1>
            <!-- 表单 -->
            <form method="post" action="/course/create">
                <div class="form-group">
                    <label for="course_name">课程名称</label>
                    <input type="text" class="form-control" id="course_name" name="course_name" required>
                </div>
                <div class="form-group">
                    <label for="teacher_id">选择教师</label>
                    <select class="form-control" id="teacher_id" name="teacher_id" required>
                        <?php foreach ($teachers as $teacher): ?>
                            <option value="<?php echo $teacher['id']; ?>"><?php echo $teacher['name']; ?></option>
                        <?php endforeach; ?>
                    </select>
                </div>
                <button type="submit" class="btn btn-primary">创建课程</button>
            </form>
        </div>
    </div>
</div>

<script src="https://code.jquery.com/jquery-3.5.1.slim.min.js"></script>
<script src="https://cdn.jsdelivr.net/npm/@popperjs/core@2.11.6/dist/umd/popper.min.js"></script>
<script src="https://stackpath.bootstrapcdn.com/bootstrap/4.5.2/js/bootstrap.min.js"></script>

</body>
</html>
