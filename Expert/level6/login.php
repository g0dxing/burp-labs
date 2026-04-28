<?php
header('Content-Type: text/html; charset=utf-8');
require_once __DIR__ . '/../../common/ui.php';

$users = [
    'admin'  => 'qq@123456',
];

$lockFile = __DIR__ . '/lock.json';
$threshold = 5; 
$lockDuration = 60; 

if (!file_exists($lockFile)) {
    file_put_contents($lockFile, json_encode(new stdClass(), JSON_PRETTY_PRINT | JSON_UNESCAPED_UNICODE));
}

$lockData = json_decode(file_get_contents($lockFile), true);
if (!is_array($lockData)) { $lockData = []; }

$username = isset($_POST['username']) ? trim($_POST['username']) : '';
$password = isset($_POST['password']) ? $_POST['password'] : '';

$isKnownUser = array_key_exists($username, $users);
$now = time();

if ($isKnownUser && !isset($lockData[$username])) {
    $lockData[$username] = [
        'fail_count' => 0, 
        'locked' => false,
        'lock_until' => 0
    ];
}

if ($isKnownUser && isset($lockData[$username]['locked']) && $lockData[$username]['locked'] === true) {
    if (isset($lockData[$username]['lock_until']) && $now > $lockData[$username]['lock_until']) {
        $lockData[$username]['locked'] = false;
        $lockData[$username]['fail_count'] = 0;
        $lockData[$username]['lock_until'] = 0;
        file_put_contents($lockFile, json_encode($lockData, JSON_PRETTY_PRINT | JSON_UNESCAPED_UNICODE));
    } else {
        render_error('Access Denied', '账户已锁定，请稍后再试。');
        exit;
    }
}

if ($isKnownUser) {
    $correctPassword = $users[$username];
    if ($password === $correctPassword) {
        $lockData[$username]['fail_count'] = 0;
        $lockData[$username]['locked'] = false;
        $lockData[$username]['lock_until'] = 0;
        file_put_contents($lockFile, json_encode($lockData, JSON_PRETTY_PRINT | JSON_UNESCAPED_UNICODE));
        render_success('Login Successful', 'Welcome, ' . htmlspecialchars($username) . '! Your flag is: flag{4a8b7c9d-3f6e-4a5c-9d2e-f8b7c1a6d3e0}', 'login.html');
        exit;
    } else {
        if ($password === '') {
            render_error('Login Failed', 'Invalid username or password');
            exit;
        }
        $lockData[$username]['fail_count'] = isset($lockData[$username]['fail_count']) ? $lockData[$username]['fail_count'] + 1 : 1;
        
        if ($lockData[$username]['fail_count'] >= $threshold) {
            $lockData[$username]['locked'] = true;
            $lockData[$username]['lock_until'] = $now + $lockDuration;
            file_put_contents($lockFile, json_encode($lockData, JSON_PRETTY_PRINT | JSON_UNESCAPED_UNICODE));
            render_error('Access Denied', '账户已锁定，请稍后再试。');
            exit;
        }
        
        file_put_contents($lockFile, json_encode($lockData, JSON_PRETTY_PRINT | JSON_UNESCAPED_UNICODE));
        render_error('Login Failed', 'Invalid username or password');
        exit;
    }
} else {
    render_error('Login Failed', 'Invalid username or password');
    exit;
}
?>
