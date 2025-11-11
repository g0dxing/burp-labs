<?php
// level22/logout.php
require_once 'check_auth.php';

clearAuth();

echo json_encode([
    'success' => true,
    'message' => '已成功退出登录'
]);
?>