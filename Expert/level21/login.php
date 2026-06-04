<?php
// Level 23: 漏洞点为用户枚举（根据账号存在与否返回不同错误信息）
session_start();

// 模拟一个真实环境中的用户数据库（明文密码仅用于靶场演示）
// 仅保留一个正确账号：durant（密码仅用于靶场演示）
$users = [
    'durant' => 'Durant!23',
];

// 仅接受 POST 登录
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

// 简单校验：防止空提交
if ($username === '' || $password === '') {
    http_response_code(400);
    renderError('账号或密码错误');
    exit;
}

// 枚举型逻辑：
// 1) 若账号不存在，返回“账号或密码错误”（泛化错误）。
// 2) 若账号存在但密码错误，返回“密码错误”（具体错误）。
// 这样攻击者可通过差异化反馈枚举出有效用户名。
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

// 登录成功：跳转到受限页面
$_SESSION['user'] = $username;
header('Location: welcome.html');
exit;

// ---- 页面渲染辅助函数 ----
function renderError(string $message): void {
    // 极简错误页，展示差异化提示并提供返回链接
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