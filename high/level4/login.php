<?php
require_once __DIR__ . '/../../common/ui.php';

// 获取原始的POST数据
$json = file_get_contents('php://input');
$data = json_decode($json, true);

// 初始化变量
$username = '';
$password = '';

// 如果是JSON请求，从JSON中获取
if ($data !== null) {
    $username = isset($data['username']) ? trim($data['username']) : '';
    $password = isset($data['password']) ? trim($data['password']) : '';
} 
// 为了兼容性或者防止意外，也可以保留常规POST支持（可选，但题目强调JSON，所以优先JSON）
// 如果JSON解析失败，尝试从$_POST获取（虽然前端我们会强制发JSON）
else {
    $username = isset($_POST['username']) ? trim($_POST['username']) : '';
    $password = isset($_POST['password']) ? trim($_POST['password']) : '';
}

// 简单的验证逻辑
if ($username === 'admin' && $password === '123456789qq') {
    // 登录成功
    render_success('Login Successful', 'Welcome, admin! Your flag is: flag{7c4a9b8d-3f6e-4a5c-9d2e-f8b7c3a6d1e0}', null);
} else {
    // 登录失败
    render_error('Login Failed', 'Invalid username or password');
}
?>
