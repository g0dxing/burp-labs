<?php
session_start();

// 设置请求频率限制 (秒)
$rate_limit = 3;

// 检查请求频率
if (isset($_SESSION['last_request_time'])) {
    $current_time = microtime(true);
    $last_time = $_SESSION['last_request_time'];
    $elapsed = $current_time - $last_time;
    
    // 只有当时间差确实小于限制时才拦截
    if ($elapsed < $rate_limit) {
        require_once __DIR__ . '/../../common/ui.php';
        // 不回显具体等待时间，只提示请求过于频繁
        render_error('请求过于频繁', '请稍后再试', 429);
        exit;
    }
}

// 记录本次请求时间
$_SESSION['last_request_time'] = microtime(true);

// 关键：立即保存 Session 数据并释放锁
session_write_close();

$valid_username = 'admin';
$valid_password = 'welcome123';

if ($_SERVER['REQUEST_METHOD'] === 'POST') {
    $username = $_POST['username'] ?? '';
    $password = $_POST['password'] ?? '';
    
    require_once __DIR__ . '/../../common/ui.php';
    if ($username === $valid_username && $password === $valid_password) {
        render_success('Login Successful', 'Welcome, admin! Your flag is: flag{3d7a9b8c-5f4e-4a2c-9d6e-f8b7c1a3d5e0}', null);
    } else {
        render_error('Login Failed','Invalid username or password');
    }
} else {
    // 非POST请求重定向到登录页
    require_once __DIR__ . '/../../common/ui.php';
    render_error('方法不被允许','仅支持 POST 登录请求',405);
    exit;
}
?>
