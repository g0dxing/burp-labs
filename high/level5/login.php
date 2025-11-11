<?php
header('Content-Type: application/json');

// 获取原始的POST数据（Base64编码的字符串）
$base64Data = file_get_contents('php://input');

// 检查数据是否为空
if (empty($base64Data)) {
    echo json_encode([
        'success' => false,
        'message' => '未接收到有效数据'
    ]);
    exit;
}

// 尝试解码Base64数据
$jsonString = base64_decode($base64Data);
if ($jsonString === false) {
    echo json_encode([
        'success' => false,
        'message' => 'Base64解码失败'
    ]);
    exit;
}

// 将JSON数据解码为PHP数组
$data = json_decode($jsonString, true);

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

// 验证逻辑
if ($username === 'admin' && $password === '1234568') {
    // 登录成功
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