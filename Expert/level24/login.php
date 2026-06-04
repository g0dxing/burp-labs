<?php
// Level 26: Username enumeration via response timing
// 统一错误信息，但在用户名存在时执行更耗时的操作，导致时延差异
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
    // 用户名不存在：快速失败（极小延时，模拟随机抖动）
    usleep(random_int(5000, 15000));
    http_response_code(401);
    renderError('账号或密码错误');
    exit;
}

// 用户名存在：执行更耗时的操作以模拟真实场景（如慢哈希校验）
// 注意：这里用 usleep 人为放大差异，便于演练
usleep(random_int(350000, 550000));

if (!hash_equals($users[$username], $password)) {
    http_response_code(401);
    // 与用户名不存在时保持相同的错误文案，避免通过提示枚举
    renderError('账号或密码错误');
    exit;
}

// 登录成功
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