<?php
// Level 29 - 2FA broken logic
// GET /login2.php?verify=<user> 会为该用户生成新的 2FA 验证码。
// POST /login2.php 使用 mfa-code 与 verify 参数校验。
// 漏洞：不校验当前登录态，攻击者可对任意用户触发验证码生成并暴力破解。

header('Content-Type: text/html; charset=utf-8');

$storeFile = __DIR__ . '/mfa.json';
if (!file_exists($storeFile)) {
    file_put_contents($storeFile, json_encode(new stdClass(), JSON_PRETTY_PRINT | JSON_UNESCAPED_UNICODE));
}
$store = json_decode(file_get_contents($storeFile), true);
if (!is_array($store)) { $store = []; }

if ($_SERVER['REQUEST_METHOD'] === 'GET') {
    $verify = isset($_GET['verify']) ? trim($_GET['verify']) : '';
    if ($verify === '') {
        echo renderForm('', '');
        exit;
    }
    // 生成4位数字验证码（不显示给用户）
    $code = str_pad((string)random_int(0, 9999), 4, '0', STR_PAD_LEFT);
    $store[$verify] = ['code' => $code, 'ts' => time()];
    file_put_contents($storeFile, json_encode($store, JSON_PRETTY_PRINT | JSON_UNESCAPED_UNICODE));
    echo renderForm($verify, '');
    exit;
}

if ($_SERVER['REQUEST_METHOD'] === 'POST') {
    $verify = isset($_POST['verify']) ? trim($_POST['verify']) : '';
    $mfa = isset($_POST['mfa-code']) ? trim($_POST['mfa-code']) : '';
    $record = isset($store[$verify]) ? $store[$verify] : null;
    if ($verify === '' || $mfa === '' || !$record) {
        echo renderForm($verify, '验证码错误');
        exit;
    }
    if ($mfa === $record['code']) {
        header('Location: welcome.html');
        exit;
    } else {
        echo renderForm($verify, '验证码错误');
        exit;
    }
}

function renderForm($verify, $error) {
    $errorHtml = $error !== '' ? '<div class="msg">' . htmlspecialchars($error, ENT_QUOTES, 'UTF-8') . '</div>' : '';
    return '<!DOCTYPE html>
    <html lang="zh-CN"><head><meta charset="UTF-8"><meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Level 29 - 二步验证</title>
    <style>
        body { font-family: Arial, sans-serif; background-color: #f4f4f4; display: flex; justify-content: center; align-items: center; height: 100vh; margin: 0; }
        .login-container { background: #fff; padding: 30px; border-radius: 8px; box-shadow: 0 4px 12px rgba(0,0,0,0.08); width: 300px; }
        h2 { text-align: center; color: #333; margin-bottom: 20px; }
        .form-group { margin-bottom: 15px; }
        label { display: block; margin-bottom: 6px; color: #555; font-weight: bold; }
        input[type="text"], input[type="password"], input[type="number"] { width: 100%; padding: 10px; border: 1px solid #ccc; border-radius: 4px; box-sizing: border-box; }
        input[type="submit"] { width: 100%; padding: 10px; background-color: #4CAF50; color: white; border: none; border-radius: 4px; cursor: pointer; }
        input[type="submit"]:hover { background-color: #45a049; }
        .msg { color: #555; margin-bottom: 15px; text-align: center; }
    </style></head>
    <body>
        <div class="login-container">
            <h2>二步验证</h2>
            '.$errorHtml.'
            <form action="login2.php" method="POST">
                <div class="form-group">
                    <label for="verify">验证用户</label>
                    <input type="text" id="verify" name="verify" placeholder="例如：carlos" value="'.htmlspecialchars($verify, ENT_QUOTES, 'UTF-8').'" required>
                </div>
                <div class="form-group">
                    <label for="mfa">验证码</label>
                    <input type="text" id="mfa" name="mfa-code" placeholder="4位验证码" required>
                </div>
                <input type="submit" value="提交">
            </form>
        </div>
    </body></html>';
}