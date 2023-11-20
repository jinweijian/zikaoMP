<!DOCTYPE html>
<html lang="zh-CN">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>创建班级</title>
    <link rel="stylesheet" href="https://stackpath.bootstrapcdn.com/bootstrap/4.5.2/css/bootstrap.min.css">
</head>
<body>

<div class="container mt-4">

    <!-- 导航栏与头部 -->
    <?php echo getHeard($user);?>

    <div class="row mt-3">
        <!-- 侧边栏 -->
        <?php echo getNavbar($user);?>

        <!-- 表单 -->
        <div class="col-md-9">
            <h1>创建班级</h1>
            <form action="/class/create" method="post">
                <div class="form-group">
                    <label for="class_name">班级名称：</label>
                    <input type="text" class="form-control" id="class_name" name="class_name" required>
                </div>

                <div class="form-group">
                    <label for="teacher_id">辅导员：</label>
                    <select class="form-control" id="teacher_id" name="teacher_id" required>
                        <?php foreach ($teachers as $teacher): ?>
                            <option value="<?php echo $teacher['id']; ?>"><?php echo $teacher['name']; ?></option>
                        <?php endforeach; ?>
                    </select>
                </div>
                <button type="submit" class="btn btn-primary">创建班级</button>
            </form>
        </div>

    </div>
</div>

<script src="https://code.jquery.com/jquery-3.5.1.slim.min.js"></script>
<script src="https://cdn.jsdelivr.net/npm/@popperjs/core@2.11.6/dist/umd/popper.min.js"></script>
<script src="https://stackpath.bootstrapcdn.com/bootstrap/4.5.2/js/bootstrap.min.js"></script>

</body>
</html>