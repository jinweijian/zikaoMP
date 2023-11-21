<!DOCTYPE html>
<html lang="zh-CN">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>班级详情</title>
    <link rel="stylesheet" href="https://stackpath.bootstrapcdn.com/bootstrap/4.5.2/css/bootstrap.min.css">
</head>
<body>

<div class="container mt-4">
    <?php echo getHeard($user); ?>

    <div class="row mt-3">
        <?php echo getNavbar($user); ?>

        <div class="col-md-9">
            <!-- 班级详情 -->
            <div class="card">
                <div class="card-header">
                    班级详情
                </div>
                <div class="card-body">
                    <h5 class="card-title">班级名称: <?php echo $class['class_name']; ?></h5>
                    <h6 class="card-title">班级学生数量: <?php echo $studentTotalPage; ?></h6>
                    <!-- 其他班级信息... -->
                </div>
            </div>

            <!-- 班级学生列表 -->
            <div class="mt-4">
                <h2>班级学生列表</h2>
                <table class="table table-bordered table-hover">
                    <thead>
                    <tr>
                        <th>ID</th>
                        <th>姓名</th>
                        <th>性别</th>
                        <th>操作</th>
                    </tr>
                    </thead>
                    <tbody>
                    <?php foreach ($students as $student): ?>
                        <tr>
                            <td><?php echo $student['id']; ?></td>
                            <td><?php echo $student['name']; ?></td>
                            <td><?php echo $student['gender']; ?></td>
                            <td>
                                <a href="/student/detail?id=<?php echo $student['id']; ?>" class="btn btn-info btn-sm">查看学生</a>
                            </td>
                        </tr>
                    <?php endforeach; ?>
                    </tbody>
                </table>
                <!-- 分页器 -->
                <?php echo generatePagination($page, $studentTotalPage);?>
            </div>
        </div>
    </div>
</div>

<script src="https://code.jquery.com/jquery-3.5.1.slim.min.js"></script>
<script src="https://cdn.jsdelivr.net/npm/@popperjs/core@2.11.6/dist/umd/popper.min.js"></script>
<script src="https://stackpath.bootstrapcdn.com/bootstrap/4.5.2/js/bootstrap.min.js"></script>

</body>
</html>
