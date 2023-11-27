<!DOCTYPE html>
<html lang="zh-CN">

<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>用户列表</title>
    <link rel="stylesheet" href="https://stackpath.bootstrapcdn.com/bootstrap/4.5.2/css/bootstrap.min.css">
    <script src="https://code.jquery.com/jquery-3.5.1.min.js"></script>

</head>

<body>

<div class="container mt-4">
    <?php echo getHeard($user); ?>

    <div class="row mt-3">
        <?php echo getNavbar($user, $menuSlug); ?>

        <div class="col-md-9">
        <!-- 用户列表表格 -->
            <h1>用户列表</h1>
            <table class="table table-bordered table-hover">
                <thead>
                <tr>
                    <th>ID</th>
                    <th>用户名</th>
                    <th>权限</th>
                    <th>操作</th>
                </tr>
                </thead>
                <tbody>
                <?php foreach ($users as $user): ?>
                    <tr>
                        <td><?php echo $user['id']; ?></td>
                        <td><?php echo $user['username']; ?></td>
                        <td><?php echo $user['role']; ?></td>
                        <td>
                            <!-- 修改密码按钮，触发弹窗 -->
                            <button type="button" class="btn btn-primary btn-sm" data-toggle="modal" data-target="#changePasswordModal-<?php echo $user['id']; ?>">
                                修改密码
                            </button>
                            <!-- 修改密码弹窗 -->
                            <div class="modal fade" id="changePasswordModal-<?php echo $user['id']; ?>" tabindex="-1" role="dialog" aria-labelledby="changePasswordModalLabel" aria-hidden="true">
                                <div class="modal-dialog" role="document">
                                    <div class="modal-content">
                                        <div class="modal-header">
                                            <h5 class="modal-title" id="changePasswordModalLabel">修改密码</h5>
                                            <button type="button" class="close" data-dismiss="modal" aria-label="Close">
                                                <span aria-hidden="true">&times;</span>
                                            </button>
                                        </div>
                                        <div class="modal-body">
                                            <!-- 修改密码表单 -->
                                            <form id="changePasswordForm-<?php echo $user['id']; ?>">
                                                <input type="hidden" name="user_id" value="<?php echo $user['id']; ?>">
                                                <div class="form-group">
                                                    <label for="newPassword-<?php echo $user['id']; ?>">新密码</label>
                                                    <input type="password" class="form-control" id="newPassword-<?php echo $user['id']; ?>" name="new_password" required>
                                                </div>
                                            </form>
                                        </div>
                                        <div class="modal-footer">
                                            <!-- 关闭按钮 -->
                                            <button type="button" class="btn btn-secondary" data-dismiss="modal">关闭</button>
                                            <!-- 保存按钮，调用 JavaScript 函数处理修改密码 -->
                                            <button type="button" class="btn btn-primary" onclick="changePassword(<?php echo $user['id']; ?>)">保存</button>
                                        </div>
                                    </div>
                                </div>
                            </div>
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
<script src="https://cdn.jsdelivr.net/npm/@popperjs/core@2.11.6/dist/umd/popper.min.js"></script>
<script src="https://stackpath.bootstrapcdn.com/bootstrap/4.5.2/js/bootstrap.min.js"></script>

<script>
    function changePassword(userId) {
        var form = $('#changePasswordForm-' + userId);
        var formData = form.serialize();

        $.ajax({
            url: '/user/changePassword',
            type: 'post',
            data: formData,
            dataType: 'json',
            success: function (response) {
                if (response.success) {
                    // 修改成功
                    alert('密码修改成功！');
                    $('#changePasswordModal-' + userId).modal('hide');
                } else {
                    // 修改失败
                    alert('密码修改失败！');
                }
            },
            error: function () {
                // 发生错误
                alert('发生错误，请重试！');
            }
        });
    }
</script>

</body>

</html>
