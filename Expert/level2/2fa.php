<?php
// Level 24: 2FA 页面（存在简单绕过）
session_start();
require_once __DIR__ . '/../../common/ui.php';

// 如果没有经过第一步登录，给出提示
if (!isset($_SESSION['preauth']) && !isset($_SESSION['user'])) {
    render_error('Access Denied', 'Please login first.', 'login.html');
    exit;
}

$username = isset($_GET['username']) ? (string)$_GET['username'] : (isset($_SESSION['pending_user']) ? (string)$_SESSION['pending_user'] : '');
if ($username === '') { $username = 'wiener'; }

if ($_SERVER['REQUEST_METHOD'] === 'POST') {
    $code = isset($_POST['code']) ? trim((string)$_POST['code']) : '';
    // 简单模拟：验证码固定为 123456
    if ($code === '123456' && isset($_SESSION['pending_user'])) {
        $_SESSION['user'] = $_SESSION['pending_user'];
        unset($_SESSION['pending_user']);
        unset($_SESSION['preauth']);
        render_success('Login Successful', 'Welcome, ' . htmlspecialchars($_SESSION['user']) . '!', null, 'account.php?username=' . rawurlencode($_SESSION['user']));
        exit;
    }
    // 验证码错误时不退出，继续显示表单，但为了统一风格，这里可以使用 render_error 并带上返回链接
    // 不过 2FA 页面比较特殊，它是中间态。为了体验，我们可以让 render_error 返回到当前页? 不太好。
    // 简单起见，如果验证码错，直接显示错误页面，用户点返回重试。
    render_error('Login Failed', '验证码错误，请重试', '2fa.php?username=' . rawurlencode($username));
    exit;
}

// 显示 2FA 表单
?>
<!DOCTYPE html>
<html lang="zh-CN">
<head>
    <meta charset="utf-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>二步验证</title>
    <style>
        body { font-family: Arial, sans-serif; background-color: #f4f4f4; display: flex; justify-content: center; align-items: center; height: 100vh; margin: 0; }
        .login-container { background-color: white; padding: 30px; border-radius: 8px; box-shadow: 0 0 10px rgba(0, 0, 0, 0.1); width: 300px; }
        h2 { text-align: center; color: #333; margin-bottom: 20px; }
        .form-group { margin-bottom: 15px; }
        label { display: block; margin-bottom: 5px; font-weight: bold; }
        input[type="text"] { width: 100%; padding: 10px; border: 1px solid #ddd; border-radius: 4px; box-sizing: border-box; }
        button { width: 100%; padding: 10px; background-color: #4CAF50; color: white; border: none; border-radius: 4px; cursor: pointer; font-size: 16px; }
        button:hover { background-color: #45a049; }
        .msg { margin-bottom: 15px; color: #555; font-size: 0.9em; text-align: center; }
        .home-back{ text-align:center; margin-top:14px; }
        .home-btn{ display:inline-block; padding:8px 14px; background:#4CAF50; color:#fff; border-radius:8px; text-decoration:none; box-shadow:0 2px 6px rgba(0,0,0,.15); }
        .home-btn:hover{ background:#45a049; }
    </style>
</head>
<body>
    <div class="login-container">
        <h2>二步验证</h2>
        <p class="msg">我们已向账号 <strong><?php echo htmlspecialchars($username, ENT_QUOTES | ENT_SUBSTITUTE, 'UTF-8'); ?></strong> 发送验证码。</p>
        <form method="POST" autocomplete="off">
            <div class="form-group">
                <label for="code">验证码</label>
                <input id="code" name="code" type="text" placeholder="例如：123456" required>
            </div>
            <button type="submit">验证并登录</button>
        </form>
        <p class="home-back"><a class="home-btn" href="login.html">Back to Login</a></p>
    </div>
</body>
</html>
