<?php
// Level 24: 2FA 页面（存在简单绕过）
session_start();

// 如果没有经过第一步登录，给出提示，但本关卡的漏洞在于账户页会信任URL参数
if (!isset($_SESSION['preauth']) && !isset($_SESSION['user'])) {
    echo '<!DOCTYPE html><html lang="zh-CN"><meta charset="utf-8"><body>';
    echo '<p>请先登录。</p><p><a href="login.html">返回登录页</a></p>';
    echo '</body></html>';
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
        header('Location: account.php?username=' . rawurlencode($_SESSION['user']));
        exit;
    }
    $error = '验证码错误，请重试';
}

echo '<!DOCTYPE html><html lang="zh-CN">';
echo '<head><meta charset="utf-8"><meta name="viewport" content="width=device-width, initial-scale=1.0">';
echo '<title>二步验证</title>';
echo '<style>body{font-family:-apple-system,BlinkMacSystemFont,\'Segoe UI\',Roboto,Arial,sans-serif;display:grid;place-items:center;min-height:100vh;background:#0f172a;color:#e5e7eb;margin:0}';
echo '.card{width:360px;max-width:92vw;background:#111827;border:1px solid #374151;border-radius:12px;padding:24px;box-shadow:0 10px 25px rgba(0,0,0,.35)}';
echo '.msg{margin:0 0 12px;font-size:1rem;color:#93c5fd}.err{color:#fca5a5;margin-bottom:12px}label{display:block;margin-bottom:6px;color:#cbd5e1}input{width:100%;padding:10px 12px;border:1px solid #374151;border-radius:8px;background:#0b1220;color:#e5e7eb}button{width:100%;padding:10px 12px;border:none;border-radius:8px;background:#2563eb;color:#fff;font-weight:600;cursor:pointer}button:hover{background:#1d4ed8}a{color:#93c5fd}';
echo '</style></head><body>';
echo '<div class="card">';
echo '<h1 style="margin:0 0 8px;font-size:1.25rem;">二步验证</h1>';
echo '<p class="msg">我们已向账号 <strong>' . htmlspecialchars($username, ENT_QUOTES | ENT_SUBSTITUTE, 'UTF-8') . '</strong> 发送验证码。</p>';
if (isset($error)) { echo '<p class="err">' . htmlspecialchars($error, ENT_QUOTES | ENT_SUBSTITUTE, 'UTF-8') . '</p>'; }
echo '<form method="POST" autocomplete="off" novalidate>';
echo '<label for="code">验证码</label>';
echo '<input id="code" name="code" type="text" placeholder="例如：123456" required />';
echo '<div style="height:10px"></div>';
echo '<button type="submit">验证并登录</button>';
echo '</form>';
echo '<p style="margin-top:12px"><a href="login.html">返回登录页</a></p>';
echo '</div></body></html>';