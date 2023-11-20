<!DOCTYPE html>
<html lang="zh-CN">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>教师列表</title>
    <link rel="stylesheet" href="https://stackpath.bootstrapcdn.com/bootstrap/4.5.2/css/bootstrap.min.css">
</head>
<body>

<div class="container mt-4">

    <?php echo getHeard($user); ?>

    <div class="row mt-3">
        <?php echo getNavbar($user); ?>

        <div class="col-md-9">
            <h1>教师列表</h1>
            <div class='d-flex justify-content-between align-items-center'>
                <div>
                    <a href='/teacher/create' class='btn btn-danger'>创建教师</a>
                </div>
            </div>
            <table class="table table-bordered table-hover">
                <thead>
                <tr>
                    <th>ID</th>
                    <th>姓名</th>
                    <th>操作</th>
                </tr>
                </thead>
                <tbody>
                <?php foreach ($teachers as $teacher): ?>
                    <tr>
                        <td><?php echo $teacher['id']; ?></td>
                        <td><?php echo $teacher['name']; ?></td>
                        <td>
                            <a href="/teacher/search?id=<?php echo $teacher['id']; ?>" class="btn btn-info btn-sm">查看</a>
                            <a href="/teacher/edit?id=<?php echo $teacher['id']; ?>" class="btn btn-warning btn-sm">编辑</a>
                            <a href="/teacher/delete?id=<?php echo $teacher['id']; ?>&timespan=<?php echo time()?>" class="btn btn-danger btn-sm">删除</a>
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
