<?php
// Level 25: 重置密码页面（逻辑缺陷点在最终处理对用户名的信任）
session_start();

$username = isset($_GET['username']) ? trim((string)$_GET['username']) : '';
if ($username === '') { $username = isset($_SESSION['pending_reset']) ? (string)$_SESSION['pending_reset'] : 'wiener'; }

// 展示重置表单，不严格校验 token（模拟“Broken Logic”）
echo '<!DOCTYPE html><html lang="zh-CN">';
echo '<head><meta charset="utf-8"><meta name="viewport" content="width=device-width, initial-scale=1.0">';
echo '<title>重置密码</title>';
echo '<style>body{font-family:Arial,sans-serif;background-color:#f4f4f4;display:flex;justify-content:center;align-items:center;height:100vh;margin:0}';
echo '.login-container{background-color:#fff;padding:30px;border-radius:8px;box-shadow:0 0 10px rgba(0,0,0,0.1);width:300px}';
echo 'h2{text-align:center;color:#333;margin-bottom:20px}.form-group{margin-bottom:15px}label{display:block;margin-bottom:5px;font-weight:bold;color:#555}input{width:100%;padding:10px;border:1px solid #ddd;border-radius:4px;box-sizing:border-box}input[type=submit]{width:100%;padding:10px;background-color:#4CAF50;color:#fff;border:none;border-radius:4px;cursor:pointer;font-size:16px}input[type=submit]:hover{background-color:#45a049}a{color:#1a73e8;text-decoration:none}';
echo '</style></head><body>';
echo '<div class="login-container">';
echo '<h2>重置密码</h2>';
echo '<p style="margin:0 0 12px;color:#555">为账号 <strong>' . htmlspecialchars($username, ENT_QUOTES | ENT_SUBSTITUTE, 'UTF-8') . '</strong> 设置新密码。</p>';
echo '<form method="POST" action="do-reset.php?username=' . rawurlencode($username) . '" autocomplete="off" novalidate>';
echo '<div class="form-group"><label for="new">新密码</label><input id="new" name="new" type="password" placeholder="输入新密码" required /></div>';
echo '<div class="form-group"><label for="confirm">重复新密码</label><input id="confirm" name="confirm" type="password" placeholder="再次输入新密码" required /></div>';
echo '<input type="submit" value="提交重置" />';
echo '</form>';
echo '<p style="margin-top:12px"><a href="reset-request.html">返回重置请求页</a></p>';
echo '</div></body></html>';