<?php
require_once __DIR__ . '/../../common/ui.php';

// 获取原始的POST数据（md5编码的字符串）
$md5Data = file_get_contents('php://input');

// 检查数据是否为空
if (empty($md5Data)) {
    render_error('Login Failed', '未接收到有效数据');
    exit;
}

// 目标凭据
$json = json_encode(["username"=>"admin","password"=>"ansible"], JSON_UNESCAPED_UNICODE);
$expected = md5(base64_encode($json));

// 验证逻辑
if ($md5Data === $expected) {
    // 登录成功
    render_success('Login Successful', 'Welcome, admin! Your flag is: flag{9a2c7b8d-4f6e-4a3c-9d5e-f8b7c1a6d3e0}', null);
} else {
    // 登录失败
    render_error('Login Failed', 'Invalid username or password');
}
?>
