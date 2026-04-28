<?php
header('Content-Type: text/html; charset=utf-8');
require_once __DIR__ . '/../../common/ui.php';

$users = [
    'test' => '123456',
    'admin'  => 'backup123'
];

$username = isset($_POST['username']) ? trim($_POST['username']) : '';
$password = isset($_POST['password']) ? $_POST['password'] : '';

if ($username === '' || $password === '') {
    render_error('Login Failed', 'Invalid username or password');
    exit;
}

if (array_key_exists($username, $users) && $users[$username] === $password) {
    header('Location: login2.php?verify=' . urlencode($username));
    exit;
} else {
    render_error('Login Failed', 'Invalid username or password');
    exit;
}
?>
