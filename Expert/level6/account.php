<?php
// Level 24: 账户页（漏洞：信任 URL 中的 username 参数，可绕过 2FA 并提权）
session_start();

// 若完成第一步登录（preauth）或已完成2FA（user），即可访问账户页
if (!isset($_SESSION['preauth']) && !isset($_SESSION['user'])) {
    echo '<!DOCTYPE html><html lang="zh-CN"><meta charset="utf-8"><body>';
    echo '<p>请先登录。</p><p><a href="login.html">返回登录页</a></p>';
    echo '</body></html>';
    exit;
}

// 漏洞点：信任 URL 参数中的 username，未校验是否为当前用户
$paramUser = isset($_GET['username']) ? trim((string)$_GET['username']) : '';
$currentUser = isset($_SESSION['user']) ? (string)$_SESSION['user'] : '';
$username = $paramUser !== '' ? $paramUser : $currentUser;
if ($username === '') { $username = 'wiener'; }

// 模拟账户数据
$profiles = [
    'wiener' => [ 'role' => 'user', 'email' => 'wiener@example.com', 'notes' => 'Regular user account' ],
    'administrator' => [ 'role' => 'admin', 'email' => 'admin@example.com', 'notes' => 'Administrator account – full privileges' ],
];

$profile = $profiles[$username] ?? [ 'role' => 'unknown', 'email' => 'unknown@example.com', 'notes' => 'No profile found' ];

echo '<!DOCTYPE html><html lang="zh-CN">';
echo '<head><meta charset="utf-8"><meta name="viewport" content="width=device-width, initial-scale=1.0">';
echo '<title>我的账户</title>';
echo '<style>body{font-family:-apple-system,BlinkMacSystemFont,\'Segoe UI\',Roboto,Arial,sans-serif;display:grid;place-items:center;min-height:100vh;background:#0f172a;color:#e5e7eb;margin:0}';
echo '.card{width:420px;max-width:92vw;background:#111827;border:1px solid #374151;border-radius:12px;padding:24px;box-shadow:0 10px 25px rgba(0,0,0,.35)}';
echo 'h1{margin:0 0 8px;font-size:1.35rem}p{margin:0 0 10px;color:#cbd5e1}code{background:#0b1220;padding:2px 6px;border-radius:6px;border:1px solid #374151}a{color:#93c5fd}';
echo '</style></head><body>';
echo '<div class="card">';
echo '<h1>账户概览</h1>';
echo '<p>当前查看的账号：<code>' . htmlspecialchars($username, ENT_QUOTES | ENT_SUBSTITUTE, 'UTF-8') . '</code></p>';
echo '<p>角色：' . htmlspecialchars($profile['role'], ENT_QUOTES | ENT_SUBSTITUTE, 'UTF-8') . '</p>';
echo '<p>邮箱：' . htmlspecialchars($profile['email'], ENT_QUOTES | ENT_SUBSTITUTE, 'UTF-8') . '</p>';
echo '<p>备注：' . htmlspecialchars($profile['notes'], ENT_QUOTES | ENT_SUBSTITUTE, 'UTF-8') . '</p>';
echo '<p style="margin-top:12px"><a href="login.html">退出并返回登录页</a></p>';
echo '</div></body></html>';