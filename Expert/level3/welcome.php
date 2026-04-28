<?php
session_start();
require_once __DIR__ . '/../../common/ui.php';

// 检查是否登录
if (!isset($_SESSION['user'])) {
    render_error('Access Denied', 'Please login first.', 'login.html');
    exit;
}

$username = $_SESSION['user'];

// 使用统一的 render_success 风格，并传入返回首页的 URL
// 第三个参数是 $back_url
render_success('Login Successful', 'Welcome, ' . htmlspecialchars($username) . '! Your flag is: flag{6c3a9b7d-4f8e-4a2c-9d5e-f7b8c1a6d3e0}', null);
?>
