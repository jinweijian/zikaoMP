<!DOCTYPE html>
<html lang="zh-CN">

<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1, shrink-to-fit=no">
    <title>用户登录</title>

    <!-- Bootstrap CSS -->
    <link href="https://cdn.bootcdn.net/ajax/libs/twitter-bootstrap/4.5.3/css/bootstrap.min.css" rel="stylesheet">
    <style>
        body {
            font-family: '微软雅黑', 'Microsoft YaHei', sans-serif;
        }

        .container {
            padding-top: 100px;
        }

        .card {
            max-width: 400px;
            margin: auto;
            box-shadow: 0 4px 8px rgba(0, 0, 0, 0.1);
        }

        .card-title {
            font-size: 24px;
        }

        .form-group {
            margin-bottom: 20px;
        }

        .btn-primary {
            background-color: #007bff;
            border-color: #007bff;
        }

        .btn-primary:hover {
            background-color: #0056b3;
            border-color: #0056b3;
        }

        .alert-danger {
            margin-top: 20px;
            padding: 10px;
            border: 1px solid #dc3545;
            border-radius: 4px;
            color: #dc3545;
            background-color: #f8d7da;
        }
    </style>
</head>

<body class="bg-light">
<div class="container">
    <div class="card">
        <div class="card-body">
            <h2 class="card-title text-center mb-4">用户登录</h2>

            <!-- 登录失败提示 -->
            <?php if (isset($_GET['error']) && $_GET['error'] == 1) : ?>
                <div class="alert alert-danger" role="alert">
                    登录失败，请检查用户名和密码。
                </div>
            <?php endif; ?>

            <form action="/user/processLogin" method="post">
                <div class="form-group">
                    <label for="username">用户名</label>
                    <input type="text" class="form-control" id="username" name="username" placeholder="输入您的用户名">
                </div>
                <div class="form-group">
                    <label for="password">密码</label>
                    <input type="password" class="form-control" id="password" name="password" placeholder="输入您的密码">
                </div>
                <button type="submit" class="btn btn-primary btn-block">登录</button>
            </form>
        </div>
    </div>
</div>

<script src="https://cdn.bootcdn.net/ajax/libs/jquery/3.5.1/jquery.slim.min.js"></script>
<script src="https://cdn.bootcdn.net/ajax/libs/popper.js/2.6.0/umd/popper.min.js"></script>
<script src="https://cdn.bootcdn.net/ajax/libs/twitter-bootstrap/4.5.3/js/bootstrap.min.js"></script>
</body>

</html>
