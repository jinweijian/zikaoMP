<!DOCTYPE html>
<html lang="zh-CN">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>编辑学生信息</title>
    <link rel="stylesheet" href="https://stackpath.bootstrapcdn.com/bootstrap/4.5.2/css/bootstrap.min.css">
</head>
<body>

<div class="container mt-4">
    <?php echo getHeard($user); ?>

    <div class="row mt-3">
        <?php echo getNavbar($user); ?>

        <div class="col-md-9">
            <h1>编辑学生信息</h1>
            <!-- 编辑表单 -->
            <form action="/student/edit?id=<?php echo $student['id']; ?>" method="post">
                <div class="form-group">
                    <label for="name">姓名</label>
                    <input type="text" class="form-control" id="name" name="name" value="<?php echo $student['name']; ?>">
                </div>
                <div class="form-group">
                    <label for="gender">性别：</label>
                    <select class="form-control" id="gender" name="gender" required>
                        <option <?php if ($student['gender'] == 'male') { echo 'selected'; }?> value="male">男</option>
                        <option <?php if ($student['gender'] == 'female') { echo 'selected'; }?> value="female">女</option>
                    </select>
                </div>
                <div class="form-group">
                    <label for="class_id">班级：</label>
                    <select class="form-control" id="class_id" name="class_id" required>
                        <?php foreach ($classes as $class): ?>
                            <option <?php if ($class['id'] == $student['class_id']) { echo 'selected'; }?> value="<?php echo $class['id']; ?>"><?php echo $class['class_name']; ?></option>
                        <?php endforeach; ?>
                    </select>
                </div>
                <div class="form-group">
                    <label for="card_id">身份证号：</label>
                    <input type="text" disabled class="form-control" id="card_id" name="card_id" value="<?php echo $student['card_id']; ?>" required>
                </div>
                <div class="form-group">
                    <label for="phone_number">手机号：</label>
                    <input type="text" class="form-control" id="phone_number" name="phone_number" value="<?php echo $student['phone_number']; ?>" required>
                </div>
                <div class="form-group">
                    <label for="dob">出生日期：</label>
                    <input type="date" class="form-control" id="dob" name="dob" value="<?php echo $student['dob']; ?>" required>
                </div>
                <div class="form-group">
                    <label for="address">地址：</label>
                    <input type="text" class="form-control" id="address" name="address" value="<?php echo $student['phone_number']; ?>" required>
                </div>
                <input type="hidden" name="id" value="<?php echo $student['id']; ?>">
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
