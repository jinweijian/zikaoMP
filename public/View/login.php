<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Login Page</title>
</head>
<body>
<h2>Login</h2>

<?php if (isset($_GET['error']) && $_GET['error'] == 1): ?>
    <p style="color: red;">无效的用户名或密码.</p>
<?php endif; ?>

<form action="/users/process-login" method="post">
    <label for="username">用户名:</label>
    <input type="text" id="username" name="username" required>
    <br>
    <label for="password">密码:</label>
    <input type="password" id="password" name="password" required>
    <br>
    <button type="submit">登陆</button>
</form>
</body>
</html>
