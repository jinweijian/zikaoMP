<?php
// 假设已经在控制器中获取了当前登录用户的信息，并将其传递到视图

// 侧边栏功能列表
$sidebarItems = [
    ['name' => '用户列表', 'url' => '/admin/users'],
    ['name' => '查询用户', 'url' => '/admin/search-user'],
    ['name' => '统计学生成绩', 'url' => '/admin/statistics'],
    ['name' => '教师信息', 'url' => '/admin/teachers'],
    ['name' => '班级管理', 'url' => '/admin/classes'],
];

?>

<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Welcome to Admin Dashboard</title>
    <link rel="stylesheet" href="https://stackpath.bootstrapcdn.com/bootstrap/4.5.2/css/bootstrap.min.css">
</head>
<body>

<div class="container mt-4">
    <div class="d-flex justify-content-between align-items-center">
        <h1>Welcome, <?php echo $user['username'] ?? 'Guest'; ?>!</h1>
        <div class="dropdown">
            <button class="btn btn-secondary dropdown-toggle" type="button" id="userDropdown" data-toggle="dropdown"
                    aria-haspopup="true" aria-expanded="false">
                User Info
            </button>
            <div class="dropdown-menu" aria-labelledby="userDropdown">
                <a class="dropdown-item" href="#">Profile</a>
                <a class="dropdown-item" href="#">Settings</a>
                <div class="dropdown-divider"></div>
                <a class="dropdown-item" href="#">Logout</a>
            </div>
        </div>
    </div>

    <div class="row mt-4">
        <div class="col-md-3">
            <h3>Navigation</h3>
            <ul class="list-group">
                <?php foreach ($sidebarItems as $item): ?>
                    <li class="list-group-item">
                        <a href="<?php echo $item['url']; ?>"><?php echo $item['name']; ?></a>
                    </li>
                <?php endforeach; ?>
            </ul>
        </div>

        <div class="col-md-9">
            <!-- 主要内容区域，根据侧边栏导航点击的不同页面进行展示 -->
            <h2>Main Content</h2>
            <p>This is the main content area. You can customize it based on the selected sidebar navigation.</p>
        </div>
    </div>
</div>

<script src="https://code.jquery.com/jquery-3.5.1.slim.min.js"></script>
<script src="https://cdn.jsdelivr.net/npm/@popperjs/core@2.11.6/dist/umd/popper.min.js"></script>
<script src="https://stackpath.bootstrapcdn.com/bootstrap/4.5.2/js/bootstrap.min.js"></script>

</body>
</html>
