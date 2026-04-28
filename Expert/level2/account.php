<?php
session_start();
require_once __DIR__ . '/../../common/ui.php';

if (!isset($_SESSION['preauth']) && !isset($_SESSION['user'])) {
    render_error('Access Denied', 'Please login first.', 'login.html');
    exit;
}

$paramUser = isset($_GET['username']) ? trim((string)$_GET['username']) : '';

$currentUser = '';
if (isset($_SESSION['user'])) {
    $currentUser = $_SESSION['user'];
} elseif (isset($_SESSION['pending_user'])) {
    $currentUser = $_SESSION['pending_user'];
}

$username = $paramUser !== '' ? $paramUser : $currentUser;

if ($username === '') { $username = 'admin'; }

$profiles = [
    'admin' => [ 'role' => 'user', 'email' => 'admin@example.com', 'notes' => 'Regular user account' ],
    'administrator' => [ 'role' => 'admin', 'email' => 'admin@example.com', 'notes' => 'Administrator account – full privileges' ],
];

$profile = $profiles[$username] ?? [ 'role' => 'unknown', 'email' => 'unknown@example.com', 'notes' => 'No profile found' ];

?>
<!DOCTYPE html>
<html lang="zh-CN">
<head>
    <meta charset="utf-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>我的账户</title>
    <style>
        body { font-family: Arial, sans-serif; background-color: #f4f4f4; display: flex; justify-content: center; align-items: center; height: 100vh; margin: 0; }
        .card { background-color: white; padding: 30px; border-radius: 8px; box-shadow: 0 0 10px rgba(0, 0, 0, 0.1); width: 350px; }
        h1 { text-align: center; color: #333; margin-bottom: 20px; font-size: 1.5em; }
        .info-row { margin-bottom: 10px; color: #555; }
        .label { font-weight: bold; display: inline-block; width: 60px; }
        .value { color: #333; }
        .badge { display: inline-block; padding: 2px 6px; border-radius: 4px; font-size: 0.9em; }
        .badge-admin { background-color: #e74c3c; color: white; }
        .badge-user { background-color: #3498db; color: white; }
        .home-back{ text-align:center; margin-top:20px; }
        .home-btn{ display:inline-block; padding:8px 14px; background:#4CAF50; color:#fff; border-radius:8px; text-decoration:none; box-shadow:0 2px 6px rgba(0,0,0,.15); }
        .home-btn:hover{ background:#45a049; }
    </style>
</head>
<body>
    <div class="card">
        <h1>账户概览</h1>
        <div class="info-row">
            <span class="label">账号:</span>
            <span class="value"><?php echo htmlspecialchars($username, ENT_QUOTES | ENT_SUBSTITUTE, 'UTF-8'); ?></span>
        </div>
        <div class="info-row">
            <span class="label">角色:</span>
            <span class="value">
                <?php 
                $role = $profile['role'];
                $badgeClass = ($role === 'admin') ? 'badge-admin' : 'badge-user';
                echo '<span class="badge ' . $badgeClass . '">' . htmlspecialchars($role) . '</span>';
                ?>
            </span>
        </div>
        <div class="info-row">
            <span class="label">邮箱:</span>
            <span class="value"><?php echo htmlspecialchars($profile['email'], ENT_QUOTES | ENT_SUBSTITUTE, 'UTF-8'); ?></span>
        </div>
        <div class="info-row">
            <span class="label">备注:</span>
            <span class="value"><?php echo htmlspecialchars($profile['notes'], ENT_QUOTES | ENT_SUBSTITUTE, 'UTF-8'); ?></span>
        </div>
        
        <div style="margin-top:20px; padding:10px; background:#e6fffa; border:1px solid #38b2ac; border-radius:4px; color:#234e52; text-align:center;">
            <strong>FLAG:</strong> flag{8b4a7c9d-3f6e-4a5c-9d2e-f7b8c1a6d3e0}
        </div>

        <p class="home-back"><a class="home-btn" href="login.html">Log out</a></p>
    </div>
</body>
</html>
