<?php
// Level 25: 重置处理（漏洞：信任 URL 中的 username，未强制关联 token 或 pending 用户）
session_start();

// 初始化用户存储（与登录页一致）
if (!isset($_SESSION['users'])) {
    $_SESSION['users'] = [
        'wiener' => 'peter',
        'administrator' => 'Admin!23',
    ];
}

if ($_SERVER['REQUEST_METHOD'] !== 'POST') {
    http_response_code(405);
    echo '<!DOCTYPE html><html lang="zh-CN"><meta charset="utf-8"><body>';
    echo '<p>仅支持 POST 请求。</p>';
    echo '<a href="reset-request.html">返回重置请求页</a>';
    echo '</body></html>';
    exit;
}

$username = isset($_GET['username']) ? trim((string)$_GET['username']) : '';
$new = isset($_POST['new']) ? (string)$_POST['new'] : '';
$confirm = isset($_POST['confirm']) ? (string)$_POST['confirm'] : '';

if ($username === '' || $new === '' || $confirm === '') {
    http_response_code(400);
    renderError('参数缺失，请重试');
    exit;
}

if (!hash_equals($new, $confirm)) {
    http_response_code(400);
    renderError('两次输入的密码不一致');
    exit;
}

// 漏洞核心：直接根据 URL 中的 username 更新密码，不校验 token/pending 用户归属
$_SESSION['users'][$username] = $new;

echo '<!DOCTYPE html><html lang="zh-CN">';
echo '<head><meta charset="utf-8"><meta name="viewport" content="width=device-width, initial-scale=1.0">';
echo '<title>密码重置成功</title>';
echo '<style>body{font-family:-apple-system,BlinkMacSystemFont,\'Segoe UI\',Roboto,Arial,sans-serif;display:grid;place-items:center;min-height:100vh;background:#0f172a;color:#e5e7eb;margin:0}';
echo '.card{width:360px;max-width:92vw;background:#111827;border:1px solid #374151;border-radius:12px;padding:24px;box-shadow:0 10px 25px rgba(0,0,0,.35)}a{color:#93c5fd}';
echo '</style></head><body>';
echo '<div class="card">';
echo '<h1 style="margin:0 0 8px;font-size:1.25rem;">密码重置成功</h1>';
echo '<p>账号 <strong>' . htmlspecialchars($username, ENT_QUOTES | ENT_SUBSTITUTE, 'UTF-8') . '</strong> 的密码已更新。</p>';
echo '<p><a href="login.html">去登录</a></p>';
echo '</div></body></html>';

function renderError(string $message): void {
    echo '<!DOCTYPE html><html lang="zh-CN">';
    echo '<head><meta charset="utf-8"><meta name="viewport" content="width=device-width, initial-scale=1.0">';
    echo '<title>重置失败</title>';
    echo '<style>body{font-family:-apple-system,BlinkMacSystemFont,\'Segoe UI\',Roboto,Arial,sans-serif;display:grid;place-items:center;min-height:100vh;background:#0f172a;color:#e5e7eb;margin:0}';
    echo '.card{width:360px;max-width:92vw;background:#111827;border:1px solid #374151;border-radius:12px;padding:24px;box-shadow:0 10px 25px rgba(0,0,0,.35)}';
    echo '.msg{margin:0 0 12px;font-size:1rem;color:#fca5a5}a{color:#93c5fd}</style></head><body>';
    echo '<div class="card">';
    echo '<h1 style="margin:0 0 8px;font-size:1.25rem;">重置失败</h1>';
    echo '<p class="msg">' . htmlspecialchars($message, ENT_QUOTES | ENT_SUBSTITUTE, 'UTF-8') . '</p>';
    echo '<p><a href="reset-request.html">返回重置请求页</a></p>';
    echo '</div></body></html>';
}