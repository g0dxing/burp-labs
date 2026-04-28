<?php
session_start();
require_once __DIR__ . '/../../common/ui.php';

// 初始化用户（如果还没初始化）
if (!isset($_SESSION['users'])) {
    $_SESSION['users'] = [
        'admin' => 'abc123',
        'administrator' => 'abc123',
    ];
}

$username = isset($_POST['username']) ? trim((string)$_POST['username']) : '';

if ($_SERVER['REQUEST_METHOD'] === 'POST') {
    if ($username === '') {
        render_error('错误', '请输入用户名', 'forgot_password.html');
        exit;
    }

    // 检查用户是否存在
    if (!array_key_exists($username, $_SESSION['users'])) {
        render_error('错误', '用户不存在', 'forgot_password.html');
        exit;
    }

    $token = md5(uniqid($username, true));
    $_SESSION['reset_tokens'][$token] = $username;
    
    // 模拟邮件服务器页面
    render_success(
        '邮件已发送', 
        '请检查您的电子邮件收件箱以获取重置链接。', 
        null,
        'email_client.php?username=' . urlencode($username) . '&token=' . $token // 自动跳转到模拟邮件客户端
    );
    exit;
}
?>
