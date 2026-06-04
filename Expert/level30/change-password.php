<?php
// Level 32 - 修改密码逻辑（存在错误消息枚举漏洞 + 错误锁定）

header('Content-Type: text/html; charset=utf-8');

$baseDir = __DIR__;
$usersPath = $baseDir . '/users.json';
$lockPath  = $baseDir . '/lock.json';

function read_json($path, $fallback) {
    if (!file_exists($path)) { return $fallback; }
    $data = json_decode(file_get_contents($path), true);
    return is_array($data) ? $data : $fallback;
}

function write_json($path, $data) {
    file_put_contents($path, json_encode($data, JSON_PRETTY_PRINT | JSON_UNESCAPED_UNICODE));
}

$username = $_POST['username'] ?? '';
$current  = $_POST['current-password'] ?? '';
$new1     = $_POST['new-password-1'] ?? '';
$new2     = $_POST['new-password-2'] ?? '';

$users = read_json($usersPath, []);
$lock  = read_json($lockPath, []);

// 账户锁定检查
if (isset($lock[$username]) && $lock[$username] === true) {
    $message = 'Your account is locked';
    $class = 'error';
} else {
    $correct = (isset($users[$username]) && $users[$username] === $current);

    if (!$correct) {
        if ($new1 === $new2) {
            // 错误当前密码 + 新密码匹配 => 锁定
            $lock[$username] = true;
            write_json($lockPath, $lock);
            $message = 'Your account is locked';
            $class = 'error';
        } else {
            // 错误当前密码 + 新密码不匹配 => 可用于枚举
            $message = 'Current password is incorrect';
            $class = 'error';
        }
    } else {
        if ($new1 !== $new2) {
            // 正确当前密码 + 新密码不匹配 => 漏洞标志
            $message = 'New passwords do not match';
            $class = 'warn';
        } else {
            // 正确当前密码 + 新密码匹配 => 修改成功
            $users[$username] = $new1;
            write_json($usersPath, $users);
            $message = 'Password changed successfully';
            $class = 'success';
        }
    }
}

?>
<!DOCTYPE html>
<html lang="zh-CN">
<head>
  <meta charset="UTF-8" />
  <meta name="viewport" content="width=device-width, initial-scale=1.0" />
  <title>修改密码结果</title>
  <style>
    body { font-family: Arial, sans-serif; background-color: #f4f4f4; display: flex; justify-content: center; align-items: center; height: 100vh; margin: 0; }
    .login-container { background-color: white; padding: 30px; border-radius: 8px; box-shadow: 0 0 10px rgba(0,0,0,0.1); width: 340px; }
    h2 { text-align: center; color: #333; margin-bottom: 16px; }
    p { text-align: center; }
    .error { color: #d93025; }
    .warn { color: #f39c12; }
    .success { color: #2ecc71; }
    .links { margin-top: 12px; font-size: 14px; text-align: center; }
    .links a { color: #1a73e8; text-decoration: none; }
  </style>
</head>
<body>
  <div class="login-container">
    <h2>修改密码结果</h2>
    <p class="<?php echo $class; ?>"><?php echo htmlspecialchars($message); ?></p>
    <div class="links">
      <a href="account.php">返回我的账户</a>
      &nbsp;|&nbsp;
      <a href="login.html">登录页</a>
    </div>
  </div>
</body>
</html>