<!DOCTYPE html>
<html lang="zh-CN">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>学生列表</title>
    <link rel="stylesheet" href="https://stackpath.bootstrapcdn.com/bootstrap/4.5.2/css/bootstrap.min.css">
</head>
<body>

<div class="container mt-4">

    <?php echo getHeard($user); ?>

    <div class="row mt-3">
        <?php echo getNavbar($user); ?>

        <div class="col-md-9">
            <h1>学生列表</h1>
            <div class='d-flex justify-content-between align-items-center'>
                <div>
                    <a href='/student/create' class='btn btn-danger'>创建学生</a>
                </div>
            </div>
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
                            <a href="/student/search?id=<?php echo $student['id']; ?>" class="btn btn-info btn-sm">查看</a>
                            <a href="/student/edit?id=<?php echo $student['id']; ?>" class="btn btn-warning btn-sm">编辑</a>
                            <a href="/student/delete?id=<?php echo $student['id']; ?>&timespan=<?php echo time()?>" class="btn btn-danger btn-sm">删除</a>
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