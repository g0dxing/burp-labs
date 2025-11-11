<?php
// Level 30 - 账户页，使用可预测的 "stay-logged-in" Cookie 进行认证

// 演示用用户表
$users = [
  'wiener' => 'peter',
  'carlos' => 'qwerty',
  'admin'  => 'admin123'
];

// 根据 Cookie 进行认证（无额外保护，存在逻辑缺陷）
$auth = false;
$cookieUser = null;
if (isset($_COOKIE['stay-logged-in'])) {
  $raw = base64_decode($_COOKIE['stay-logged-in'], true);
  if ($raw !== false) {
    $parts = explode(':', $raw, 2);
    if (count($parts) === 2) {
      list($u, $hash) = $parts;
      if (isset($users[$u]) && md5($users[$u]) === $hash) {
        $auth = true;
        $cookieUser = $u;
      }
    }
  }
}

// 页面展示的目标用户（攻击时可改为 carlos）
$target = isset($_GET['id']) ? $_GET['id'] : $cookieUser;
if ($target === null) { $target = 'guest'; }

// 未认证则返回 401
if (!$auth) {
  http_response_code(401);
}
?>
<!DOCTYPE html>
<html lang="zh-CN">
<head>
  <meta charset="UTF-8" />
  <meta name="viewport" content="width=device-width, initial-scale=1.0" />
  <title>账户中心</title>
  <style>
    body { font-family: Arial, sans-serif; background-color: #f4f4f4; display: flex; justify-content: center; align-items: center; height: 100vh; margin: 0; }
    .login-container { background-color: white; padding: 30px; border-radius: 8px; box-shadow: 0 0 10px rgba(0, 0, 0, 0.1); width: 300px; }
    h2 { text-align: center; color: #333; margin-bottom: 20px; }
    .form-group { margin-bottom: 15px; }
    label { display: block; margin-bottom: 6px; color: #555; font-weight: bold; }
    input[type="email"] { width: 100%; padding: 10px; border: 1px solid #ddd; border-radius: 4px; box-sizing: border-box; }
    button { width: 100%; padding: 10px; background-color: #4CAF50; color: white; border: none; border-radius: 4px; cursor: pointer; font-size: 16px; }
    button:hover { background-color: #45a049; }
    .links { margin-top: 12px; font-size: 14px; text-align: center; }
    .links a { color: #1a73e8; text-decoration: none; }
    .muted { color: #777; font-size: 12px; text-align: center; }
  </style>
</head>
<body>
  <div class="login-container">
    <h2>账户中心</h2>
    <?php if ($auth): ?>
      <div class="form-group"><strong>当前查看用户：</strong> <?php echo htmlspecialchars($target, ENT_QUOTES, 'UTF-8'); ?></div>
      <div class="muted">已通过保持登录 Cookie 认证</div>
      <div class="form-group">
        <label for="email">邮箱</label>
        <input id="email" type="email" value="<?php echo htmlspecialchars($target . '@example.com', ENT_QUOTES, 'UTF-8'); ?>" />
      </div>
      <button type="button">Update email</button>
      <div class="links"><a href="logout.php">退出登录</a></div>
    <?php else: ?>
      <p class="muted">未认证或 Cookie 无效。请返回登录并勾选保持登录。</p>
      <div class="links"><a href="login.html">返回登录</a></div>
    <?php endif; ?>
  </div>
</body>
</html>