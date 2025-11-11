<?php
$user = $_COOKIE['lab33_user'] ?? '';
?>
<!DOCTYPE html>
<html lang="zh-CN">
<head>
  <meta charset="UTF-8" />
  <meta name="viewport" content="width=device-width, initial-scale=1.0" />
  <title>Level 33 - 我的账户</title>
  <style>
    body { font-family: Arial, sans-serif; background-color: #f4f4f4; display: flex; justify-content: center; align-items: center; height: 100vh; margin: 0; }
    .login-container { background-color: white; padding: 30px; border-radius: 8px; box-shadow: 0 0 10px rgba(0,0,0,0.1); width: 360px; }
    h2 { text-align: center; color: #333; margin-bottom: 10px; }
    p { color: #555; text-align: center; }
    .actions { margin-top: 16px; text-align: center; }
    a.button { display: inline-block; padding: 10px 16px; background-color: #1a73e8; color: #fff; border-radius: 4px; text-decoration: none; }
    a.button:hover { background-color: #1669c1; }
  </style>
</head>
<body>
  <div class="login-container">
    <?php if ($user === ''): ?>
      <h2>请先登录</h2>
      <div class="actions"><a class="button" href="login.html">前往登录</a></div>
    <?php else: ?>
      <h2>我的账户 - <?php echo htmlspecialchars($user); ?></h2>
      <p>登录成功，欢迎使用。</p>
      <div class="actions">
        <a class="button" href="logout.php">登出</a>
      </div>
    <?php endif; ?>
  </div>
</body>
</html>