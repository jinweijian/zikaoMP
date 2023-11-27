<!DOCTYPE html>
<html lang="zh-CN">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>成绩详情</title>
    <link rel="stylesheet" href="https://stackpath.bootstrapcdn.com/bootstrap/4.5.2/css/bootstrap.min.css">
</head>
<body>

<div class="container mt-4">

    <?php echo getNavbar($user, $menuSlug); ?>

    <div class="row mt-3">
        <div class="col-md-9">
            <h1>成绩详情</h1>
            <table class="table table-bordered">
                <tbody>
                <tr>
                    <th>ID</th>
                    <td><?php echo $grade['id']; ?></td>
                </tr>
                <tr>
                    <th>学生姓名</th>
                    <td><?php echo $student['name']; ?></td>
                </tr>
                <tr>
                    <th>课程名称</th>
                    <td><?php echo $course['name']; ?></td>
                </tr>
                <tr>
                    <th>分数</th>
                    <td><?php echo $grade['score']; ?></td>
                </tr>
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
