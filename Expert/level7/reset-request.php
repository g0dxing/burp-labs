<?php
session_start();

// 初始化用户存储（与登录页一致）
if (!isset($_SESSION['users'])) {
    $_SESSION['users'] = [
        'wiener' => 'peter',
        'administrator' => 'Admin!23',
    ];
}

if ($_SERVER['REQUEST_METHOD'] !== 'POST') {
    http_response_code(405);
    echo '<!DOCTYPE html><html lang="zh-CN"><meta charset="utf-8"><body>';
    echo '<p>仅支持 POST 请求。</p>';
    echo '<a href="reset-request.html">返回重置请求页</a>';
    echo '</body></html>';
    exit;
}

$identity = isset($_POST['identity']) ? trim((string)$_POST['identity']) : '';
if ($identity === '') {
    http_response_code(400);
    echo '<!DOCTYPE html><html lang="zh-CN"><meta charset="utf-8"><body>';
    echo '<p>请输入用户名或邮箱。</p>';
    echo '<a href="reset-request.html">返回重置请求页</a>';
    echo '</body></html>';
    exit;
}

// 简单映射：若包含 @，提取 @ 前作为用户名，否则直接当作用户名
$username = strpos($identity, '@') !== false ? substr($identity, 0, strpos($identity, '@')) : $identity;

// 通知：“已发送邮件”，并设置预重置状态（模拟真实流程）
$_SESSION['pending_reset'] = $username;
$_SESSION['reset_token'] = 'RESET-123456'; // 仅用于模拟，不会被严格校验

// 发送后的页面：提示已发送并给出下一步链接（漏洞将出现在下一页的校验）
header('Location: reset.php?username=' . rawurlencode($username));
exit;