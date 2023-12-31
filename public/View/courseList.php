<!DOCTYPE html>
<html lang="zh-CN">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>选课列表</title>
    <link rel="stylesheet" href="https://stackpath.bootstrapcdn.com/bootstrap/4.5.2/css/bootstrap.min.css">
</head>
<body>

<div class="container mt-4">
    <?php echo getHeard($user); ?>

    <div class="row mt-3">
        <?php echo getNavbar($user, $menuSlug); ?>

        <div class="col-md-9">
            <h1>选课列表</h1>
            <div class='d-flex justify-content-between align-items-center'>
                <div>
                    <a href='/course/create' class='btn btn-danger'>创建选课</a>
                </div>
            </div>
            <form method="get" action="/course/list">

                <input type="text" class="form-control" id="name" name="name" value="<?php echo $_GET['name'] ?? '';?>">

                <button type="submit" class="btn btn-primary" >搜索</button>
            </form>
            <!-- 列表 -->
            <table class="table table-bordered table-hover">
                <thead>
                <tr>
                    <th>ID</th>
                    <th>选课名称</th>
                    <th>教师</th>
                    <th>已选修人数</th>
                    <th>操作</th>
                </tr>
                </thead>
                <tbody>
                <?php foreach ($courses as $course): ?>
                    <tr>
                        <td><?php echo $course['id']; ?></td>
                        <td><?php echo $course['course_name']; ?></td>
                        <td><?php echo $course['teacher_name']; ?></td>
                        <td><?php echo $course['total']; ?></td>
                        <td>
                            <a href="/course/detail?id=<?php echo $course['id']; ?>" class="btn btn-info btn-sm">详情</a>
                            <a href="/course/edit?id=<?php echo $course['id']; ?>" class="btn btn-warning btn-sm">编辑</a>
                            <a href="/course/delete?id=<?php echo $course['id']; ?>&timespan=<?php echo time(); ?>" class="btn btn-danger btn-sm" onclick="return confirm('确定删除该选课吗？')">删除</a>
                        </td>
                    </tr>
                <?php endforeach; ?>
                </tbody>
            </table>

            <!-- 分页器 -->
            <?php echo generatePagination($page, $total);?>
        </div>
    </div>
</div>

<script src="https://code.jquery.com/jquery-3.5.1.slim.min.js"></script>
<script src="https://cdn.jsdelivr.net/npm/@popperjs/core@2.11.6/dist/umd/popper.min.js"></script>
<script src="https://stackpath.bootstrapcdn.com/bootstrap/4.5.2/js/bootstrap.min.js"></script>

</body>
</html>
