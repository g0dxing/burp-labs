<?php
// Level 29 - 2FA broken logic
// 登录后进入 /login2.php?verify=<username>，GET 生成该用户的2FA码，POST 校验。
// 漏洞：GET 的 verify 可被任意指定，从而为目标用户生成验证码；随后暴力破解 mfa-code。

header('Content-Type: text/html; charset=utf-8');

$users = [
    'carlos' => 'qwerty',
    'wiener' => 'peter',
    'admin'  => 'admin123'
];

$username = isset($_POST['username']) ? trim($_POST['username']) : '';
$password = isset($_POST['password']) ? $_POST['password'] : '';

if ($username === '' || $password === '') {
    echo renderMessage('用户名或密码错误');
    exit;
}

if (array_key_exists($username, $users) && $users[$username] === $password) {
    // 正确密码，进入 2FA 第一步（生成验证码）
    header('Location: login2.php?verify=' . urlencode($username));
    exit;
} else {
    echo renderMessage('用户名或密码错误');
    exit;
}

function renderMessage($msg) {
    return '<!DOCTYPE html>
    <html lang="zh-CN"><head><meta charset="UTF-8"><meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Level 29 - 登录反馈</title>
    <style>
        body { font-family: Arial, sans-serif; background-color: #f4f4f4; display: flex; justify-content: center; align-items: center; height: 100vh; margin: 0; }
        .login-container { background: #fff; padding: 30px; border-radius: 8px; box-shadow: 0 4px 12px rgba(0,0,0,0.08); width: 300px; }
        h2 { text-align: center; color: #333; margin-bottom: 20px; }
        .msg { color: #555; margin-bottom: 15px; text-align: center; }
        .btn { display: block; width: 100%; padding: 10px; background-color: #4CAF50; color: #fff; text-decoration: none; border-radius: 4px; text-align: center; }
        .btn:hover { background-color: #45a049; }
    </style></head>
    <body><div class="login-container">
        <h2>Level 29 - 登录反馈</h2>
        <div class="msg">' . htmlspecialchars($msg, ENT_QUOTES, 'UTF-8') . '</div>
        <a class="btn" href="login.html">返回登录</a>
    </div></body></html>';
}