<?php
header('Content-Type: application/json');

// 获取原始的POST数据（md5编码的字符串）
$md5Data = file_get_contents('php://input');

// 检查数据是否为空
if (empty($md5Data)) {
    echo json_encode([
        'success' => false,
        'message' => '未接收到有效数据'
    ]);
    exit;
}



$md5='b0f265981de8c55658ae8c91c6103276';//{"username":"admin","password":"qaz123qaz"}
// 验证逻辑
if ($md5Data===$md5) {
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