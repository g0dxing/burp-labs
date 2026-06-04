<?php
session_start();

// 设置请求频率限制 (秒)
$rate_limit = 1; // 每次请求最小间隔3秒

// 检查请求频率
if (isset($_SESSION['last_request_time'])) {
    $elapsed = time() - $_SESSION['last_request_time'];
    if ($elapsed < $rate_limit) {
        header("Location: login.html?error=请求过于频繁");
        exit();
    }
}

// 记录本次请求时间
$_SESSION['last_request_time'] = time();

// 模拟用户验证 (实际使用中替换为你的验证逻辑)
$valid_username = 'admin';
$valid_password = '123456';

if ($_SERVER['REQUEST_METHOD'] === 'POST') {
    $username = $_POST['username'] ?? '';
    $password = $_POST['password'] ?? '';
    
    if ($username === $valid_username && $password === $valid_password) {
        // 登录成功
        echo "登录成功!";
        // 这里可以设置登录session等操作
    } else {
        // 登录失败
        header("Location: login.html?error=用户名或密码错误");
        exit();
    }
} else {
    // 非POST请求重定向到登录页
    header("Location: login.html");
    exit();
}
?>