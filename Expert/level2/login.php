<?php
session_start();
require_once __DIR__ . '/../../common/ui.php';

$users = [
    'admin' => '12345678',
    'administrator' => '12345678',
];

if ($_SERVER['REQUEST_METHOD'] !== 'POST') {
    render_error('方法不被允许', '仅支持 POST 登录请求', 'login.html');
    exit;
}

$username = isset($_POST['username']) ? trim((string)$_POST['username']) : '';
$password = isset($_POST['password']) ? (string)$_POST['password'] : '';

if ($username === '' || $password === '') {
    render_error('Login Failed', 'Invalid username or password');
    exit;
}

if (!array_key_exists($username, $users)) {
    render_error('Login Failed', 'Invalid username or password');
    exit;
}

if (!hash_equals($users[$username], $password)) {
    render_error('Login Failed', '密码错误');
    exit;
}

$_SESSION['preauth'] = true;
$_SESSION['pending_user'] = $username;

render_success('第一步验证通过', '正在跳转至双因素验证...', null, '2fa.php?username=' . rawurlencode($username));
exit;
?>
