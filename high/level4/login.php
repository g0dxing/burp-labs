<?php
header('Content-Type: application/json');

// 获取原始的POST数据
$json = file_get_contents('php://input');

// 将JSON数据解码为PHP数组
$data = json_decode($json, true);

// 检查JSON解码是否成功
if (json_last_error() !== JSON_ERROR_NONE) {
    echo json_encode([
        'success' => false,
        'message' => '无效的JSON数据'
    ]);
    exit;
}

// 检查用户名和密码是否存在
if (!isset($data['username']) || !isset($data['password'])) {
    echo json_encode([
        'success' => false,
        'message' => '用户名和密码不能为空'
    ]);
    exit;
}

// 获取用户名和密码
$username = trim($data['username']);
$password = trim($data['password']);

// 简单的验证逻辑 - 在实际应用中应该使用数据库验证和密码哈希
if ($username === 'admin' && $password === '1314521521') {
    // 登录成功
    // 在实际应用中，这里应该设置session或token
    echo json_encode([
        'success' => true,
        'message' => '登录成功'
    ]);
} else {
    // 登录失败
    echo json_encode([
        'success' => false,
        'message' => '用户名或密码错误'
    ]);
}
?>