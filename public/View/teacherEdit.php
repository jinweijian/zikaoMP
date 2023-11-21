<!DOCTYPE html>
<html lang="zh-CN">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>编辑教师信息</title>
    <link rel="stylesheet" href="https://stackpath.bootstrapcdn.com/bootstrap/4.5.2/css/bootstrap.min.css">
</head>
<body>

<div class="container mt-4">
    <?php echo getHeard($user); ?>

    <div class="row mt-3">
        <?php echo getNavbar($user); ?>

        <div class="col-md-9">
            <h1>编辑教师信息</h1>
            <!-- 编辑表单 -->
            <form action="/teacher/edit?id=<?php echo $teacher['id']; ?>" method="post">
                <div class="form-group">
                    <label for="name">姓名</label>
                    <input type="text" class="form-control" id="name" name="name" value="<?php echo $teacher['name']; ?>">
                </div>
<!--                <div class="form-group">-->
<!--                    <label for="gender">性别：</label>-->
<!--                    <select class="form-control" id="gender" name="gender" required>-->
<!--                        <option --><?php //if ($teacher['gender'] == 'male') { echo 'selected'; }?><!-- value="male">男</option>-->
<!--                        <option --><?php //if ($teacher['gender'] == 'female') { echo 'selected'; }?><!-- value="female">女</option>-->
<!--                    </select>-->
<!--                </div>-->
<!--                -->
                <div class="form-group">
                    <label for="card_id">身份证号：</label>
                    <input type="text" disabled class="form-control" id="card_id" name="card_id" value="<?php echo $teacher['card_id']; ?>" required>
                </div>
                <div class="form-group">
                    <label for="phone_number">手机号：</label>
                    <input type="text" class="form-control" id="phone_number" name="phone_number" value="<?php echo $teacher['phone_number']; ?>" required>
                </div>
                <input type="hidden" name="id" value="<?php echo $teacher['id']; ?>">
                <button type="submit" class="btn btn-primary">保存</button>
            </form>
        </div>
    </div>
</div>

<script src="https://code.jquery.com/jquery-3.5.1.slim.min.js"></script>
<script src="https://cdn.jsdelivr.net/npm/@popperjs/core@2.11.6/dist/umd/popper.min.js"></script>
<script src="https://stackpath.bootstrapcdn.com/bootstrap/4.5.2/js/bootstrap.min.js"></script>

</body>
</html>
