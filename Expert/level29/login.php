<?php
// Level 31 - 登录后端（用于在完成重置后验证登录）

function read_users() {
    $path = __DIR__ . '/users.json';
    if (!file_exists($path)) {
        // 初始化一些示例用户
        $default = [
            'wiener' => 'peter',
            'carlos' => 'qwerty',
            'admin'  => 'admin123'
        ];
        file_put_contents($path, json_encode($default, JSON_PRETTY_PRINT | JSON_UNESCAPED_UNICODE));
        return $default;
    }
    $data = json_decode(file_get_contents($path), true);
    return is_array($data) ? $data : [];
}

$users = read_users();
$username = $_POST['username'] ?? '';
$password = $_POST['password'] ?? '';

if (isset($users[$username]) && $users[$username] === $password) {
    header('Location: welcome.html');
    exit;
}

// 失败页面（统一样式）
?>
<!DOCTYPE html>
<html lang="zh-CN">
<head>
  <meta charset="UTF-8" />
  <meta name="viewport" content="width=device-width, initial-scale=1.0" />
  <title>登录失败</title>
  <style>
    body { font-family: Arial, sans-serif; background-color: #f4f4f4; display: flex; justify-content: center; align-items: center; height: 100vh; margin: 0; }
    .login-container { background-color: white; padding: 30px; border-radius: 8px; box-shadow: 0 0 10px rgba(0,0,0,0.1); width: 300px; }
    h2 { text-align: center; color: #d93025; margin-bottom: 16px; }
    p { color: #555; text-align: center; }
    .links { margin-top: 12px; font-size: 14px; text-align: center; }
    .links a { color: #1a73e8; text-decoration: none; }
  </style>
</head>
<body>
  <div class="login-container">
    <h2>登录失败</h2>
    <p>用户名或密码错误。</p>
    <div class="links">
      <a href="login.html">返回登录</a>
      &nbsp;|&nbsp;
      <a href="forgot-password.html">忘记密码？</a>
    </div>
  </div>
</body>
</html>