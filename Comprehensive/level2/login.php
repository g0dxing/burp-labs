<?php
// 第22关 - 外贸网站登录系统
header('Content-Type: application/json');
session_start();

// 引入权限检查文件
require_once 'check_auth.php';

// 正确的管理员凭据
$correct_username = 'admin';
$correct_password = 'morningstar_XingHao';

// 获取POST数据
$input = json_decode(file_get_contents('php://input'), true);
$username = $input['username'] ?? '';
$password = $input['password'] ?? '';

// 安全验证
if (empty($username) || empty($password)) {
    echo json_encode([
        'success' => false,
        'message' => '账号和密码不能为空！'
    ]);
    exit();
}

if ($username === $correct_username && $password === $correct_password) {
    // 登录成功，设置session
    setAuth($username);
    
    echo json_encode([
        'success' => true,
        'message' => '登录成功！',
        'user' => [
            'id' => 1,
            'name' => '管理员',
            'username' => $username
        ]
    ]);
} else {
    // 登录失败
    echo json_encode([
        'success' => false,
        'message' => '账号或密码错误！'
    ]);
}
?>