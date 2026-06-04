<?php
setcookie('lab33_user', '', time() - 3600, '/');
?>
<!DOCTYPE html>
<html lang="zh-CN">
<head>
  <meta charset="UTF-8" />
  <meta name="viewport" content="width=device-width, initial-scale=1.0" />
  <title>已登出</title>
  <style>
    body { font-family: Arial, sans-serif; background-color: #f4f4f4; display: flex; justify-content: center; align-items: center; height: 100vh; margin: 0; }
    .login-container { background-color: white; padding: 30px; border-radius: 8px; box-shadow: 0 0 10px rgba(0,0,0,0.1); width: 300px; }
    h2 { text-align: center; color: #333; margin-bottom: 16px; }
    p { color: #555; text-align: center; }
    .links { margin-top: 12px; font-size: 14px; text-align: center; }
    .links a { color: #1a73e8; text-decoration: none; }
  </style>
</head>
<body>
  <div class="login-container">
    <h2>已登出</h2>
    <p>您已成功登出。</p>
    <div class="links">
      <a href="login.html">返回登录</a>
    </div>
  </div>
</body>
</html>