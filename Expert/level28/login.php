<?php
// Level 30 - 登录并可选择设置 "stay-logged-in" Cookie

// 简单的用户表（演示用途）
$users = [
  'wiener' => 'peter',
  'carlos' => 'qwerty',
  'admin'  => 'admin123'
];

$username = isset($_POST['username']) ? trim($_POST['username']) : '';
$password = isset($_POST['password']) ? $_POST['password'] : '';
$stay     = isset($_POST['stay']) ? $_POST['stay'] : '';

if ($username !== '' && isset($users[$username]) && $users[$username] === $password) {
  // 登录成功：如果勾选保持登录，则设置 cookie 为 base64(username:md5(password))
  if ($stay === '1') {
    $value = base64_encode($username . ':' . md5($password));
    // 设置 7 天有效期，路径为根目录，简化起见不设置 Secure，仅 HttpOnly
    setcookie('stay-logged-in', $value, time() + 7 * 24 * 3600, '/', '', false, true);
  }
  // 跳转到账户页，携带 id 参数（可在攻击时调为目标用户）
  header('Location: account.php?id=' . urlencode($username));
  exit;
}

// 登录失败：返回简单错误页
http_response_code(401);
?>
<!DOCTYPE html>
<html lang="zh-CN">
  <head>
    <meta charset="utf-8" />
    <meta name="viewport" content="width=device-width, initial-scale=1" />
    <title>登录失败</title>
    <style>
      body { font-family: Arial, sans-serif; background-color: #f4f4f4; display: flex; justify-content: center; align-items: center; height: 100vh; margin: 0; }
      .login-container { background-color: white; padding: 30px; border-radius: 8px; box-shadow: 0 0 10px rgba(0, 0, 0, 0.1); width: 300px; }
      h2 { text-align: center; color: #333; margin-bottom: 20px; }
      a { color: #1a73e8; text-decoration: none; display: block; text-align: center; }
      p { color: #555; text-align: center; }
    </style>
  </head>
  <body>
    <div class="login-container">
      <h2>登录失败</h2>
      <p>用户名或密码错误。</p>
      <a href="login.html">返回登录</a>
    </div>
  </body>
</html>