<?php
session_start();

// 初始化用户存储在会话中，便于重置后立刻生效
if (!isset($_SESSION['users'])) {
    $_SESSION['users'] = [
        'wiener' => 'peter',
        'administrator' => 'Admin!23',
    ];
}

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

if (!array_key_exists($username, $_SESSION['users'])) {
    http_response_code(401);
    renderError('账号或密码错误');
    exit;
}

if (!hash_equals($_SESSION['users'][$username], $password)) {
    http_response_code(401);
    renderError('密码错误');
    exit;
}

$_SESSION['user'] = $username;
header('Location: welcome.html');
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