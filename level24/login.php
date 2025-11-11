<?php
// Level 24: 模拟 PortSwigger Lab - 2FA simple bypass
session_start();

$users = [
    'wiener' => 'peter',
    'administrator' => 'Admin!23',
];

if ($_SERVER['REQUEST_METHOD'] !== 'POST') {
    http_response_code(405);
    echo '<!DOCTYPE html><html lang="zh-CN"><meta charset="utf-8"><body>';
    echo '<p>仅支持 POST 登录请求。</p>';
    echo '<a href="login.html">返回登录页</a>';
    echo '</body></html>';
    exit;
}

$username = isset($_POST['username']) ? trim((string)$_POST['username']) : '';
$password = isset($_POST['password']) ? (string)$_POST['password'] : '';

if ($username === '' || $password === '') {
    http_response_code(400);
    renderError('账号或密码错误');
    exit;
}

if (!array_key_exists($username, $users)) {
    http_response_code(401);
    renderError('账号或密码错误');
    exit;
}

if (!hash_equals($users[$username], $password)) {
    http_response_code(401);
    renderError('密码错误');
    exit;
}

// 登录第一步通过，进入 2FA 等待
$_SESSION['preauth'] = true;               // 标记已通过第一步验证
$_SESSION['pending_user'] = $username;     // 将待验证用户放入会话
header('Location: 2fa.php?username=' . rawurlencode($username));
exit;

function renderError(string $message): void {
    echo '<!DOCTYPE html><html lang="zh-CN">';
    echo '<head><meta charset="utf-8"><meta name="viewport" content="width=device-width, initial-scale=1.0">';
    echo '<title>登录失败</title>';
    echo '<style>body{font-family:-apple-system,BlinkMacSystemFont,\'Segoe UI\',Roboto,Arial,sans-serif;display:grid;place-items:center;min-height:100vh;background:#0f172a;color:#e5e7eb;margin:0}';
    echo '.card{width:360px;max-width:92vw;background:#111827;border:1px solid #374151;border-radius:12px;padding:24px;box-shadow:0 10px 25px rgba(0,0,0,.35)}';
    echo '.msg{margin:0 0 12px;font-size:1rem;color:#fca5a5}a{color:#93c5fd}</style></head><body>';
    echo '<div class="card">';
    echo '<h1 style="margin:0 0 8px;font-size:1.25rem;">登录失败</h1>';
    echo '<p class="msg">' . htmlspecialchars($message, ENT_QUOTES | ENT_SUBSTITUTE, 'UTF-8') . '</p>';
    echo '<p><a href="login.html">返回登录页</a></p>';
    echo '</div></body></html>';
}