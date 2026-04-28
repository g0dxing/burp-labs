<?php
session_start();
require_once __DIR__ . '/../../common/ui.php';

$token = isset($_GET['token']) ? $_GET['token'] : (isset($_POST['token']) ? $_POST['token'] : '');
// 漏洞点：这里接收 URL/POST 中的 username 参数，并在后续直接用于重置密码
// 正常逻辑应该根据 token 查找对应的 username，而不是信任前端传来的 username
$username = isset($_GET['username']) ? $_GET['username'] : (isset($_POST['username']) ? $_POST['username'] : '');

if ($_SERVER['REQUEST_METHOD'] === 'GET') {
    if (!$token || !$username) {
        render_error('错误', '无效的重置链接', 'login.html');
        exit;
    }
    // 显示重置密码表单
    ?>
    <!DOCTYPE html>
    <html lang="zh-CN">
    <head>
        <meta charset="UTF-8">
        <meta name="viewport" content="width=device-width, initial-scale=1.0">
        <title>设置新密码</title>
        <style>
            body { font-family: Arial, sans-serif; background-color: #f4f4f4; display: flex; justify-content: center; align-items: center; height: 100vh; margin: 0; }
            .container { background-color: white; padding: 30px; border-radius: 8px; box-shadow: 0 0 10px rgba(0, 0, 0, 0.1); width: 300px; }
            h2 { text-align: center; color: #333; margin-bottom: 20px; }
            .form-group { margin-bottom: 15px; }
            label { display: block; margin-bottom: 5px; font-weight: bold; color: #555; }
            input[type="password"] { width: 100%; padding: 10px; border: 1px solid #ddd; border-radius: 4px; box-sizing: border-box; }
            input[type="submit"] { width: 100%; padding: 10px; background-color: #4CAF50; color: white; border: none; border-radius: 4px; cursor: pointer; font-size: 16px; }
            input[type="submit"]:hover { background-color: #45a049; }
            .user-info { text-align: center; margin-bottom: 15px; color: #666; font-size: 0.9em; }
        </style>
    </head>
    <body>
        <div class="container">
            <h2>设置新密码</h2>
            <div class="user-info">为用户: <strong><?php echo htmlspecialchars($username); ?></strong></div>
            <form action="reset_password.php" method="POST">
                <input type="hidden" name="token" value="<?php echo htmlspecialchars($token); ?>">
                <!-- 漏洞点：将 username 作为隐藏字段提交，或者攻击者可以在 POST 请求中篡改它 -->
                <input type="hidden" name="username" value="<?php echo htmlspecialchars($username); ?>">
                
                <div class="form-group">
                    <label for="new_password">新密码</label>
                    <input id="new_password" name="new_password" type="password" required />
                </div>
                <div class="form-group">
                    <label for="confirm_password">确认新密码</label>
                    <input id="confirm_password" name="confirm_password" type="password" required />
                </div>
                <input type="submit" value="提交更改" />
            </form>
        </div>
    </body>
    </html>
    <?php
    exit;
}

if ($_SERVER['REQUEST_METHOD'] === 'POST') {
    $new_password = $_POST['new_password'] ?? '';
    $confirm_password = $_POST['confirm_password'] ?? '';
    
    // 漏洞点：直接使用 POST 中的 username 来重置密码，而没有校验 token 是否属于该用户
    // 正常逻辑：$valid_username = check_token($token); update_password($valid_username, ...);
    // 漏洞逻辑：verify_token_exists($token); update_password($POST['username'], ...);
    
    if ($new_password !== $confirm_password) {
        render_error('错误', '两次输入的密码不一致', "reset_password.php?token=$token&username=$username");
        exit;
    }

    // 简单校验 token 是否存在（但不校验它属于谁）
    if (!isset($_SESSION['reset_tokens'][$token])) {
         render_error('错误', '无效或过期的令牌', 'login.html');
         exit;
    }

    // 实施攻击：更新 POST 中指定的 username 的密码
    if (isset($_SESSION['users'][$username])) {
        $_SESSION['users'][$username] = $new_password;
        // 销毁 token（可选，模拟一次性）
        unset($_SESSION['reset_tokens'][$token]);
        
        render_success('成功', "用户 $username 的密码已成功重置。", 'login.html');
    } else {
        render_error('错误', '目标用户不存在', 'login.html');
    }
}
?>
