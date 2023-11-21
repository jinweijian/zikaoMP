<!DOCTYPE html>
<html lang="zh-CN">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>班级列表</title>
    <link rel="stylesheet" href="https://stackpath.bootstrapcdn.com/bootstrap/4.5.2/css/bootstrap.min.css">
</head>
<body>

<div class="container mt-4">

    <?php echo getHeard($user); ?>

    <div class="row mt-3">
        <?php echo getNavbar($user); ?>

        <div class="col-md-9">
            <h1>班级列表</h1>
            <div class='d-flex justify-content-between align-items-center'>
                <div>
                    <a href='/class/create' class='btn btn-danger'>创建班级</a>
                </div>
            </div>
            <table class="table table-bordered table-hover">
                <thead>
                <tr>
                    <th>ID</th>
                    <th>班级名称</th>
                    <th>辅导员</th>
                    <th>操作</th>
                </tr>
                </thead>
                <tbody>
                <?php foreach ($classes as $class): ?>
                    <tr>
                        <td><?php echo $class['id']; ?></td>
                        <td><?php echo $class['class_name']; ?></td>
                        <td><?php echo $class['teacher_name']; ?></td>
                        <td>
                            <a href="/class/detail?id=<?php echo $class['id']; ?>" class="btn btn-info btn-sm">查看</a>
                            <a href="/class/edit?id=<?php echo $class['id']; ?>" class="btn btn-warning btn-sm">编辑</a>
                            <a href="/class/delete?id=<?php echo $class['id']; ?>&timespan=<?php echo time()?>" class="btn btn-danger btn-sm">删除</a>
                        </td>
                    </tr>
                <?php endforeach; ?>
                </tbody>
            </table>

            <!-- 分页器 -->
            <?php echo generatePagination($page, $totalPage);?>
        </div>
    </div>
</div>

<script src="https://code.jquery.com/jquery-3.5.1.slim.min.js"></script>
<script src="https://cdn.jsdelivr.net/npm/@popperjs/core@2.11.6/dist/umd/popper.min.js"></script>
<script src="https://stackpath.bootstrapcdn.com/bootstrap/4.5.2/js/bootstrap.min.js"></script>

</body>
</html>
