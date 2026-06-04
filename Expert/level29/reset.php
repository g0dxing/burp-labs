<?php
// Level 31 - 重置页面：读取 token，允许设置新密码

header('Content-Type: text/html; charset=utf-8');

$baseDir = __DIR__;
$tokensPath = $baseDir . '/tokens.json';
$usersPath  = $baseDir . '/users.json';

function read_json($path, $fallback) {
    if (!file_exists($path)) { return $fallback; }
    $data = json_decode(file_get_contents($path), true);
    return is_array($data) ? $data : $fallback;
}

function write_json($path, $data) {
    file_put_contents($path, json_encode($data, JSON_PRETTY_PRINT | JSON_UNESCAPED_UNICODE));
}

$token = $_GET['temp-forgot-password-token'] ?? '';
$tokens = read_json($tokensPath, []);

$associatedUser = '';
if ($token !== '' && isset($tokens[$token])) {
    $associatedUser = $tokens[$token]['user'] ?? '';
}

// 处理提交新密码
if ($_SERVER['REQUEST_METHOD'] === 'POST') {
    $newpass = $_POST['new_password'] ?? '';
    $tokpost = $_POST['token'] ?? '';
    $tokens = read_json($tokensPath, []);
    if ($tokpost !== '' && isset($tokens[$tokpost]) && $newpass !== '') {
        $user = $tokens[$tokpost]['user'];
        $users = read_json($usersPath, []);
        $users[$user] = $newpass; // 直接替换（演示用）
        write_json($usersPath, $users);
        // 使用后删除 token
        unset($tokens[$tokpost]);
        write_json($tokensPath, $tokens);
        header('Location: welcome.html');
        exit;
    }
}

?>
<!DOCTYPE html>
<html lang="zh-CN">
<head>
  <meta charset="UTF-8" />
  <meta name="viewport" content="width=device-width, initial-scale=1.0" />
  <title>设置新密码</title>
  <style>
    body { font-family: Arial, sans-serif; background-color: #f4f4f4; display: flex; justify-content: center; align-items: center; height: 100vh; margin: 0; }
    .login-container { background-color: white; padding: 30px; border-radius: 8px; box-shadow: 0 0 10px rgba(0,0,0,0.1); width: 300px; }
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
    <h2>设置新密码</h2>
    <?php if ($associatedUser === ''): ?>
      <p class="tip">无效或过期的令牌。</p>
      <div class="links"><a href="forgot-password.html">返回重置</a></div>
    <?php else: ?>
      <form action="reset.php?temp-forgot-password-token=<?php echo htmlspecialchars($token); ?>" method="POST">
        <div class="form-group">
          <label for="new_password">为用户 <?php echo htmlspecialchars($associatedUser); ?> 设置新密码</label>
          <input type="password" id="new_password" name="new_password" placeholder="请输入新密码" required>
        </div>
        <input type="hidden" name="token" value="<?php echo htmlspecialchars($token); ?>">
        <input type="submit" value="提交">
      </form>
      <div class="links">
        <a href="login.html">返回登录</a>
      </div>
    <?php endif; ?>
  </div>
</body>
</html>