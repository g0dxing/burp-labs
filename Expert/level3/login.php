<?php
session_start();

function render_error_inline($title, $message, $back_url = 'login.html') {
    http_response_code(200);
    echo '<!DOCTYPE html><html lang="zh-CN"><head><meta charset="utf-8"><meta name="viewport" content="width=device-width, initial-scale=1">';
    echo '<title>' . htmlspecialchars($title) . '</title>';
    echo '<style>body{font-family:-apple-system,BlinkMacSystemFont,Segoe UI,Roboto,Arial,sans-serif;display:grid;place-items:center;min-height:100vh;background:#f4f4f4;color:#333;margin:0}';
    echo '.card{width:380px;max-width:92vw;background:#fff;border:1px solid #e5e7eb;border-radius:12px;padding:24px;box-shadow:0 10px 25px rgba(0,0,0,.08)}';
    echo '.title{margin:0 0 8px;font-size:1.25rem;color:#e74c3c}';
    echo '.msg{margin:0 0 16px;font-size:1rem;color:#555}';
    echo '.btn{display:inline-block;background:#2ecc71;color:#fff;text-decoration:none;border:none;border-radius:8px;padding:10px 14px;cursor:pointer}';
    echo '.btn:hover{background:#27ae60}</style></head><body>';
    echo '<div class="card"><h1 class="title">' . htmlspecialchars($title) . '</h1>';
    echo '<p class="msg">' . htmlspecialchars($message) . '</p>';
    if ($back_url) { echo '<p style="text-align:center"><a class="btn" href="' . htmlspecialchars($back_url) . '">Back to Login</a></p>'; }
    echo '</div></body></html>';
}

if (!isset($_SESSION['users'])) {
    $_SESSION['users'] = [
        'admin' => 'password!@#',
        'administrator' => 'newroot',
    ];
}

if ($_SERVER['REQUEST_METHOD'] !== 'POST') {
    render_error_inline('方法不被允许', '仅支持 POST 登录请求', 'login.html');
    exit;
}

$username = isset($_POST['username']) ? trim((string)$_POST['username']) : '';
$password = isset($_POST['password']) ? (string)$_POST['password'] : '';

if ($username === '' || $password === '') {
    render_error_inline('Login Failed', 'Invalid username or password');
    exit;
}

if (!array_key_exists($username, $_SESSION['users'])) {
    render_error_inline('Login Failed', 'Invalid username or password');
    exit;
}

if (!hash_equals($_SESSION['users'][$username], $password)) {
    render_error_inline('Login Failed', '密码错误');
    exit;
}

$_SESSION['user'] = $username;
header('Location: welcome.php');
exit;
?>
