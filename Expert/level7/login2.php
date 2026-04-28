<?php
session_start();
require_once __DIR__ . '/../../common/ui.php';

$mfaFile = __DIR__ . '/mfa.json';
if (!file_exists($mfaFile)) {
    file_put_contents($mfaFile, json_encode(new stdClass()));
}

$mfaData = json_decode(file_get_contents($mfaFile), true);
if (!is_array($mfaData)) { $mfaData = []; }

if ($_SERVER['REQUEST_METHOD'] === 'GET') {
    $verifyUser = isset($_GET['verify']) ? trim($_GET['verify']) : '';
    if ($verifyUser === '') {
        render_error('Error', 'Missing verify parameter');
        exit;
    }

    $code = str_pad((string)random_int(0, 9999), 4, '0', STR_PAD_LEFT);
    $mfaData[$verifyUser] = $code;
    file_put_contents($mfaFile, json_encode($mfaData, JSON_PRETTY_PRINT));

    ?>
<!DOCTYPE html>
<html lang="zh-CN">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>2FA Verification</title>
    <style>
        body { font-family: Arial, sans-serif; background-color: #f4f4f4; display: flex; justify-content: center; align-items: center; height: 100vh; margin: 0; }
        .login-container { background: #fff; padding: 30px; border-radius: 8px; box-shadow: 0 4px 12px rgba(0,0,0,0.08); width: 300px; }
        h2 { text-align: center; color: #333; margin-bottom: 20px; }
        .form-group { margin-bottom: 15px; }
        label { display: block; margin-bottom: 6px; color: #555; font-weight: bold; }
        input[type="text"] { width: 100%; padding: 10px; border: 1px solid #ccc; border-radius: 4px; box-sizing: border-box; text-align: center; letter-spacing: 4px; font-size: 1.2em; }
        input[type="submit"] { width: 100%; padding: 10px; background-color: #4CAF50; color: white; border: none; border-radius: 4px; cursor: pointer; margin-top: 10px; }
        input[type="submit"]:hover { background-color: #45a049; }
        .info { font-size: 0.9em; color: #666; text-align: center; margin-bottom: 20px; }
    </style>
</head>
<body>
    <div class="login-container">
        <h2>Two-Factor Authentication</h2>
        <p class="info">请输入发送给 <strong><?php echo htmlspecialchars($verifyUser); ?></strong> 的 4 位验证码</p>
        <form action="login2.php" method="POST">
            <input type="hidden" name="verify" value="<?php echo htmlspecialchars($verifyUser); ?>">
            <div class="form-group">
                <label for="mfa-code">Verification Code</label>
                <input type="text" id="mfa-code" name="mfa-code" maxlength="4" pattern="\d{4}" required autocomplete="off">
            </div>
            <input type="submit" value="Verify">
        </form>
    </div>
</body>
</html>
    <?php
    exit;
}

if ($_SERVER['REQUEST_METHOD'] === 'POST') {
    $verifyUser = isset($_POST['verify']) ? trim($_POST['verify']) : '';
    $inputCode = isset($_POST['mfa-code']) ? trim($_POST['mfa-code']) : '';

    if ($verifyUser === '' || $inputCode === '') {
        render_error('Login Failed', 'Invalid code');
        exit;
    }

    if (isset($mfaData[$verifyUser]) && $mfaData[$verifyUser] === $inputCode) {
        $_SESSION['user'] = $verifyUser;
        unset($mfaData[$verifyUser]);
        file_put_contents($mfaFile, json_encode($mfaData, JSON_PRETTY_PRINT));
        
        render_success('Login Successful', 'Welcome, ' . htmlspecialchars($verifyUser) . '! Your flag is: flag{7b3a9c8d-5f4e-4a2c-9d6e-f8b7c1a3d5e0}', 'login.html');
        exit;
    } else {
        render_error('Login Failed', 'Incorrect security code', "login2.php?verify=" . urlencode($verifyUser));
        exit;
    }
}
?>
