<!DOCTYPE html>
<html lang="zh-CN">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>创建教师</title>
    <link rel="stylesheet" href="https://stackpath.bootstrapcdn.com/bootstrap/4.5.2/css/bootstrap.min.css">
</head>
<body>

<div class="container mt-4">

    <!-- 导航栏与头部 -->
    <?php echo getHeard($user);?>

    <div class="row mt-3">
        <!-- 侧边栏 -->
        <?php echo getNavbar($user, $menuSlug);?>

        <!-- 表单 -->
        <div class="col-md-9">
            <h1>创建教师</h1>
            <form action="/teacher/create" method="post">
                <div class="form-group">
                    <label for="name">教师名称：</label>
                    <input type="text" class="form-control" id="name" name="name" required>
                </div>
                <div class="form-group">
                    <label for="card_id">身份证号：</label>
                    <input type="text" pattern="[0-9Xx]+" class="form-control" id="card_id" name="card_id" required>
                </div>
                <div class="form-group">
                    <label for="phone_number">手机号：</label>
                    <input type="text" pattern="[0-9]{11}" class="form-control" id="phone_number" name="phone_number" required>
                </div>

                <button type="submit" class="btn btn-primary">创建教师</button>
            </form>
        </div>

    </div>
</div>

<script src="https://code.jquery.com/jquery-3.5.1.slim.min.js"></script>
<script src="https://cdn.jsdelivr.net/npm/@popperjs/core@2.11.6/dist/umd/popper.min.js"></script>
<script src="https://stackpath.bootstrapcdn.com/bootstrap/4.5.2/js/bootstrap.min.js"></script>

</body>
</html>