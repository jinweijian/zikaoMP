<!DOCTYPE html>
<html lang="zh-CN">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>教师详情</title>
    <link rel="stylesheet" href="https://stackpath.bootstrapcdn.com/bootstrap/4.5.2/css/bootstrap.min.css">
</head>
<body>

<div class="container mt-4">
    <?php echo getHeard($user); ?>

    <div class="row mt-3">
        <?php echo getNavbar($user); ?>

        <div class="col-md-9">
            <!-- 教师详情 -->
            <div class="card">
                <div class="card-header">
                    教师详情
                </div>
                <div class="card-body">
                    <h5 class="card-title">姓名: <?php echo $teacher['name']; ?></h5>
                    <p class="card-text">手机号: <?php echo $teacher['phone_number']; ?></p>
                    <p class="card-text">身份证号码: <?php echo $teacher['card_id']; ?></p>
                    <!-- 其他教师信息... -->
                </div>
            </div>

            <!-- 教师管理的班级列表 -->
            <div class="mt-4">
                <h2>教师管理的班级列表</h2>
                <table class="table table-bordered table-hover">
                    <thead>
                    <tr>
                        <th>ID</th>
                        <th>班级名称</th>
                        <th>操作</th>
                    </tr>
                    </thead>
                    <tbody>
                    <?php foreach ($classes as $class): ?>
                        <tr>
                            <td><?php echo $class['id']; ?></td>
                            <td><?php echo $class['class_name']; ?></td>
                            <td>
                                <a href="/class/detail?id=<?php echo $class['id']; ?>" class="btn btn-info btn-sm">查看班级</a>
                            </td>
                        </tr>
                    <?php endforeach; ?>
                    </tbody>
                </table>
                <!-- 分页器 -->
                <?php echo generatePagination($page, $classTotal);?>
            </div>
        </div>
    </div>
</div>

<script src="https://code.jquery.com/jquery-3.5.1.slim.min.js"></script>
<script src="https://cdn.jsdelivr.net/npm/@popperjs/core@2.11.6/dist/umd/popper.min.js"></script>
<script src="https://stackpath.bootstrapcdn.com/bootstrap/4.5.2/js/bootstrap.min.js"></script>

</body>
</html>
