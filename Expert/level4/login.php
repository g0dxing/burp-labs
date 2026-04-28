<?php
session_start();
require_once __DIR__ . '/../../common/ui.php';

$users = [
    'admin' => 'admin!123',
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
    usleep(random_int(5000, 15000));
    render_error('Login Failed', 'Invalid username or password');
    exit;
}

usleep(random_int(350000, 550000));

if (!hash_equals($users[$username], $password)) {
    render_error('Login Failed', 'Invalid username or password');
    exit;
}

$_SESSION['user'] = $username;

render_success('Login Successful', 'Welcome, ' . htmlspecialchars($username) . '! Your flag is: flag{2a7d9b8c-4f3e-4a6c-9d5e-f8b7c1a6d2e0}', 'login.html');
exit;
?>
