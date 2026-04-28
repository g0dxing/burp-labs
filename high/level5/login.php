<?php
require_once __DIR__ . '/../../common/ui.php';

// 获取原始的POST数据（Base64编码的字符串）
$base64Data = file_get_contents('php://input');

// 检查数据是否为空
if (empty($base64Data)) {
    render_error('Login Failed', '未接收到有效数据');
    exit;
}

// 尝试解码Base64数据
$jsonString = base64_decode($base64Data);
if ($jsonString === false) {
    render_error('Login Failed', 'Base64解码失败');
    exit;
}

// 将JSON数据解码为PHP数组
$data = json_decode($jsonString, true);

// 检查JSON解码是否成功
if (json_last_error() !== JSON_ERROR_NONE) {
    // 兼容性尝试：也许base64Data本身就是URL参数形式或者其他形式？
    // 但根据题目设计，这里严格要求是Base64 Encoded JSON
    render_error('Login Failed', '无效的JSON数据');
    exit;
}

// 检查用户名和密码是否存在
if (!isset($data['username']) || !isset($data['password'])) {
    render_error('Login Failed', '用户名和密码不能为空');
    exit;
}

// 获取用户名和密码
$username = trim($data['username']);
$password = trim($data['password']);

// 验证逻辑
if ($username === 'admin' && $password === 'pass12345') {
    // 登录成功
    render_success('Login Successful', 'Welcome, admin! Your flag is: flag{5b8d7a9c-4f3e-4a6c-9d1e-f7b8c5a3d2e0}', null);
} else {
    // 登录失败
    render_error('Login Failed', 'Invalid username or password');
}
?>
