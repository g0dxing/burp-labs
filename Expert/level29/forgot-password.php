<?php
// Level 31 - 密码重置请求处理（存在中间件主机污染漏洞）

header('Content-Type: text/html; charset=utf-8');

function ensure_file($path, $defaultJson) {
    if (!file_exists($path)) {
        file_put_contents($path, $defaultJson);
    }
}

$baseDir = __DIR__;
$tokensPath = $baseDir . '/tokens.json';
$mailboxPath = $baseDir . '/mailbox.json';

ensure_file($tokensPath, json_encode([], JSON_PRETTY_PRINT | JSON_UNESCAPED_UNICODE));
ensure_file($mailboxPath, json_encode([], JSON_PRETTY_PRINT | JSON_UNESCAPED_UNICODE));

$username = $_POST['username'] ?? '';
$username = trim($username);

// 支持的用户列表（仅用于演示）
function valid_user($u) {
    $valid = ['wiener', 'carlos', 'admin'];
    return in_array($u, $valid, true);
}

// 从头部读取 X-Forwarded-Host，若存在则用于拼接重置链接的主机（漏洞点）
$forwardedHost = $_SERVER['HTTP_X_FORWARDED_HOST'] ?? '';
$defaultHost = $_SERVER['HTTP_HOST'] ?? '127.0.0.1:5173';
$hostToUse = $forwardedHost !== '' ? $forwardedHost : $defaultHost;

// 生成令牌并保存映射
function random_token($len = 24) {
    return bin2hex(random_bytes($len));
}

if ($username !== '' && valid_user($username)) {
    $token = random_token(12); // 24 hex chars
    // 保存 token->user 映射
    $tokens = json_decode(file_get_contents($tokensPath), true);
    if (!is_array($tokens)) { $tokens = []; }
    $tokens[$token] = [ 'user' => $username, 'created_at' => time() ];
    file_put_contents($tokensPath, json_encode($tokens, JSON_PRETTY_PRINT | JSON_UNESCAPED_UNICODE));

    // 组合重置链接（漏洞：受 X-Forwarded-Host 影响）
    $resetLink = 'http://' . $hostToUse . '/level31/reset.php?temp-forgot-password-token=' . urlencode($token);

    // 模拟“发送邮件”：写入邮箱箱（供学员查看）
    $mailbox = json_decode(file_get_contents($mailboxPath), true);
    if (!is_array($mailbox)) { $mailbox = []; }
    $mailbox[] = [
        'to' => $username,
        'subject' => 'Password Reset',
        'link' => $resetLink,
        'host_used' => $hostToUse,
        'time' => date('c')
    ];
    file_put_contents($mailboxPath, json_encode($mailbox, JSON_PRETTY_PRINT | JSON_UNESCAPED_UNICODE));
}

// 返回统一样式的提示页（不泄露链接）
?>
<!DOCTYPE html>
<html lang="zh-CN">
<head>
  <meta charset="UTF-8" />
  <meta name="viewport" content="width=device-width, initial-scale=1.0" />
  <title>邮件已发送</title>
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
    <h2>邮件已发送</h2>
    <p>如果用户存在，我们已向其邮箱发送重置链接。</p>
    <div class="links">
      <a href="login.html">返回登录</a>
    </div>
  </div>
</body>
</html>