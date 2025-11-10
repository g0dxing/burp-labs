<?php
// 第22关 - 外贸网站登录系统
// 使用账号密码登录，无SQL注入漏洞

header('Content-Type: application/json');

// 正确的管理员凭据
$correct_username = 'admin';
$correct_password = 'xing@15545678910';

// 获取POST数据
$input = json_decode(file_get_contents('php://input'), true);
$username = $input['username'] ?? '';
$password = $input['password'] ?? '';

// 安全验证 - 无SQL注入漏洞
if ($username === $correct_username && $password === $correct_password) {
    // 登录成功
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