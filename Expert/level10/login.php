<?php
// Level 28 - Username enumeration via account lock
// 逻辑：
// - 对已存在的用户名记录失败次数并在达到阈值后锁定账户；
// - 未存在的用户名不参与锁定计数，始终返回通用错误；
// - 利用空密码快速触发失败计数，导致有效用户名在短时间内被锁，产生可枚举的“账户已锁定”差异响应。

header('Content-Type: text/html; charset=utf-8');

$users = [
    'carlos' => 'qwerty',
    'wiener' => 'peter',
    'admin'  => 'admin123'
];

$lockFile = __DIR__ . '/lock.json';
$threshold = 5; // 失败阈值，达到后锁定

if (!file_exists($lockFile)) {
    file_put_contents($lockFile, json_encode(new stdClass(), JSON_PRETTY_PRINT | JSON_UNESCAPED_UNICODE));
}

$lockData = json_decode(file_get_contents($lockFile), true);
if (!is_array($lockData)) { $lockData = []; }

$username = isset($_POST['username']) ? trim($_POST['username']) : '';
$password = isset($_POST['password']) ? $_POST['password'] : '';

$isKnownUser = array_key_exists($username, $users);

// 初始化该用户的锁定信息（仅对已知用户）
if ($isKnownUser && !isset($lockData[$username])) {
    $lockData[$username] = ['fail_count' => 0, 'locked' => false];
}

// 如果账户已锁定（仅对已知用户），立即返回锁定提示
if ($isKnownUser && isset($lockData[$username]['locked']) && $lockData[$username]['locked'] === true) {
    echo renderMessage('账户已锁定，请稍后再试。');
    exit;
}

// 校验逻辑
if ($isKnownUser) {
    $correctPassword = $users[$username];
    if ($password === $correctPassword) {
        // 成功登录，重置失败计数
        $lockData[$username]['fail_count'] = 0;
        $lockData[$username]['locked'] = false;
        file_put_contents($lockFile, json_encode($lockData, JSON_PRETTY_PRINT | JSON_UNESCAPED_UNICODE));
        header('Location: welcome.html');
        exit;
    } else {
        // 仅错误且非空密码才计数并可能锁定；空密码不计数
        if ($password === '') {
            echo renderMessage('用户名或密码错误');
            exit;
        }
        $lockData[$username]['fail_count'] = isset($lockData[$username]['fail_count']) ? $lockData[$username]['fail_count'] + 1 : 1;
        if ($lockData[$username]['fail_count'] >= $threshold) {
            $lockData[$username]['locked'] = true;
            file_put_contents($lockFile, json_encode($lockData, JSON_PRETTY_PRINT | JSON_UNESCAPED_UNICODE));
            echo renderMessage('账户已锁定，请稍后再试。');
            exit;
        }
        file_put_contents($lockFile, json_encode($lockData, JSON_PRETTY_PRINT | JSON_UNESCAPED_UNICODE));
        echo renderMessage('用户名或密码错误');
        exit;
    }
} else {
    // 未知用户名：不计数、不锁定，返回通用错误
    echo renderMessage('用户名或密码错误');
    exit;
}

function renderMessage($msg) {
    return '<!DOCTYPE html>
    <html lang="zh-CN"><head><meta charset="UTF-8"><meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Level 28 - 登录反馈</title>
    <style>
        body { font-family: Arial, sans-serif; background-color: #f4f4f4; display: flex; justify-content: center; align-items: center; height: 100vh; margin: 0; }
        .login-container { background: #fff; padding: 30px; border-radius: 8px; box-shadow: 0 4px 12px rgba(0,0,0,0.08); width: 300px; }
        h2 { text-align: center; color: #333; margin-bottom: 20px; }
        .msg { color: #555; margin-bottom: 15px; text-align: center; }
        .btn { display: block; width: 100%; padding: 10px; background-color: #4CAF50; color: #fff; text-decoration: none; border-radius: 4px; text-align: center; }
        .btn:hover { background-color: #45a049; }
    </style></head>
    <body><div class="login-container">
        <h2>Level 28 - 登录反馈</h2>
        <div class="msg">' . htmlspecialchars($msg, ENT_QUOTES, 'UTF-8') . '</div>
        <a class="btn" href="login.html">返回登录</a>
    </div></body></html>';
}