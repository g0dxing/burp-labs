<?php
session_start();
require_once __DIR__ . '/../../common/ui.php';

// 模拟邮件客户端页面
$username = isset($_GET['username']) ? $_GET['username'] : '';
$token = isset($_GET['token']) ? $_GET['token'] : '';

// 简单的页面展示重置链接
?>
<!DOCTYPE html>
<html lang="zh-CN">
<head>
    <meta charset="UTF-8">
    <title>Webmail - Inbox</title>
    <style>
        body { font-family: Arial, sans-serif; background: #f4f4f4; margin: 0; padding: 20px; }
        .email-container { max-width: 800px; margin: 0 auto; background: white; border-radius: 8px; box-shadow: 0 0 10px rgba(0, 0, 0, 0.1); overflow: hidden; }
        /* 修改头部背景色为靶场主题绿 */
        .header { background: #4CAF50; color: white; padding: 15px 20px; font-weight: bold; }
        .content { padding: 30px; }
        .subject { font-size: 1.2em; font-weight: bold; margin-bottom: 20px; color: #333; }
        .meta { color: #555; margin-bottom: 20px; font-size: 0.9em; }
        .body { line-height: 1.6; color: #333; }
        /* 修改按钮颜色为靶场主题绿 */
        .reset-btn { display: inline-block; background: #4CAF50; color: white; padding: 10px 20px; text-decoration: none; border-radius: 4px; margin-top: 20px; }
        .reset-btn:hover { background: #45a049; }
        .raw-link { margin-top: 30px; padding: 10px; background: #f8f9fa; border: 1px solid #ddd; word-break: break-all; font-family: monospace; font-size: 0.85em; color: #555; }
    </style>
</head>
<body>
    <div class="email-container">
        <div class="header">
            Webmail - <?php echo htmlspecialchars($username); ?>@burp-labs.local
        </div>
        <div class="content">
            <div class="subject">密码重置请求</div>
            <div class="meta">
                发件人: no-reply@burp-labs.local<br>
                收件人: <?php echo htmlspecialchars($username); ?>@burp-labs.local
            </div>
            <div class="body">
                <p>亲爱的用户，</p>
                <p>我们收到了重置您账户密码的请求。</p>
                <p>请点击下面的按钮重置您的密码：</p>
                <a href="reset_password.php?token=<?php echo htmlspecialchars($token); ?>&username=<?php echo urlencode($username); ?>" class="reset-btn">重置密码</a>
                
                <p>如果您没有请求重置密码，请忽略此邮件。</p>
            </div>
            <div class="raw-link">
                <strong>Debug Info (Link):</strong><br>
                reset_password.php?token=<?php echo htmlspecialchars($token); ?>&username=<?php echo urlencode($username); ?>
            </div>
        </div>
    </div>
    <p style="text-align: center; margin-top: 20px;">
        <a href="login.html" style="color: #555;">返回登录页</a>
    </p>
</body>
</html>
