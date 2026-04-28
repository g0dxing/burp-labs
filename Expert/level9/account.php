<?php
$currentUser = $_COOKIE['lab32_user'] ?? '';
?>
<!DOCTYPE html>
<html lang="zh-CN">
<head>
  <meta charset="UTF-8" />
  <meta name="viewport" content="width=device-width, initial-scale=1.0" />
  <title>用户账户</title>
  <style>
    body { font-family: Arial, sans-serif; background-color: #f4f4f4; display: flex; justify-content: center; align-items: center; height: 100vh; margin: 0; }
    .login-container { background-color: white; padding: 30px; border-radius: 8px; box-shadow: 0 0 10px rgba(0,0,0,0.1); width: 340px; }
    h2 { text-align: center; color: #333; margin-bottom: 16px; }
    .form-group { margin-bottom: 15px; }
    label { display: block; margin-bottom: 6px; color: #555; font-weight: bold; }
    input[type="password"] { width: 100%; padding: 10px; border: 1px solid #ddd; border-radius: 4px; box-sizing: border-box; }
    input[type="submit"] { width: 100%; padding: 10px; background-color: #4CAF50; color: white; border: none; border-radius: 4px; cursor: pointer; font-size: 16px; }
    input[type="submit"]:hover { background-color: #45a049; }
    .links { margin-top: 12px; font-size: 14px; text-align: center; }
    .links a { color: #1a73e8; text-decoration: none; }
    .tip { color: #777; font-size: 13px; text-align: center; }
  </style>
</head>
<body>
  <div class="login-container">
    <?php if ($currentUser === ''): ?>
      <h2>请先登录</h2>
      <div class="links"><a href="login.html">前往登录</a></div>
    <?php else: ?>
      <h2>我的账户 - <?php echo htmlspecialchars($currentUser); ?></h2>
      <form action="change-password.php" method="POST">
        <input type="hidden" name="username" value="<?php echo htmlspecialchars($currentUser); ?>">
        <div class="form-group">
          <label for="current-password">当前密码</label>
          <input type="password" id="current-password" name="current-password" placeholder="请输入当前密码" required>
        </div>
        <div class="form-group">
          <label for="new-password-1">新密码</label>
          <input type="password" id="new-password-1" name="new-password-1" placeholder="请输入新密码" required>
        </div>
        <div class="form-group">
          <label for="new-password-2">确认新密码</label>
          <input type="password" id="new-password-2" name="new-password-2" placeholder="请再次输入新密码" required>
        </div>
        <input type="submit" value="修改密码">
      </form>
      <div class="links">
        <a href="logout.php">登出</a>
      </div>
      
      <div style="margin-top:20px; padding:15px; background:#fff3cd; border:1px solid #ffeeba; border-radius:4px; color:#856404; font-size:14px;">
        <strong>🎯 关卡目标 (Mission):</strong><br>
        虽然你现在登录的是普通用户 (<?php echo htmlspecialchars($currentUser); ?>)，但你的目标是获取管理员用户 <strong>admin</strong> 的密码。<br>
        尝试利用修改密码功能的逻辑漏洞来破解它！
      </div>

      <?php if ($currentUser === 'admin'): ?>
      <div style="margin-top:20px; padding:15px; background:#d4edda; border:1px solid #c3e6cb; border-radius:4px; color:#155724; font-size:16px; text-align:center;">
          <strong>🎉 Congratulations!</strong><br>
          Your flag is: <strong>flag{3b8a7c9d-4f6e-4a2c-9d5e-f7b8c1a6d3e0}</strong>
      </div>
      <?php endif; ?>

      <p class="tip">提示：本关卡存在逻辑漏洞，错误消息可用于枚举当前密码。</p>
    <?php endif; ?>
  </div>
</body>
</html>