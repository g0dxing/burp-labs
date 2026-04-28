<?php
header('Content-Type: text/html; charset=utf-8');
require_once __DIR__ . '/../../common/ui.php';

function ensure_file($path, $defaultJson) {
    if (!file_exists($path)) {
        file_put_contents($path, $defaultJson);
    }
}

$baseDir = __DIR__;
$tokensPath = $baseDir . '/tokens.json';
$mailboxPath = $baseDir . '/mailbox.json';

ensure_file($tokensPath, json_encode([], JSON_PRETTY_PRINT | JSON_UNESCAPED_UNICODE));
ensure_file($mailboxPath, json_encode([], JSON_PRETTY_PRINT | JSON_UNESCAPED_UNICODE));

$username = $_POST['username'] ?? '';
$username = trim($username);

function valid_user($u) {
    $valid = ['wiener', 'carlos', 'admin'];
    return in_array($u, $valid, true);
}

$forwardedHost = $_SERVER['HTTP_X_FORWARDED_HOST'] ?? '';
$defaultHost = $_SERVER['HTTP_HOST'] ?? '127.0.0.1:5173';
$hostToUse = $forwardedHost !== '' ? $forwardedHost : $defaultHost;

function random_token($len = 24) {
    return bin2hex(random_bytes($len));
}

if ($username !== '' && valid_user($username)) {
    $token = random_token(12); 
    $tokens = json_decode(file_get_contents($tokensPath), true);
    if (!is_array($tokens)) { $tokens = []; }
    $tokens[$token] = [ 'user' => $username, 'created_at' => time() ];
    file_put_contents($tokensPath, json_encode($tokens, JSON_PRETTY_PRINT | JSON_UNESCAPED_UNICODE));

    $resetLink = 'http://' . $hostToUse . '/Expert/level8/reset.php?temp-forgot-password-token=' . urlencode($token);

    $mailbox = json_decode(file_get_contents($mailboxPath), true);
    if (!is_array($mailbox)) { $mailbox = []; }
    $mailbox[] = [
        'to' => $username,
        'subject' => 'Password Reset',
        'link' => $resetLink,
        'host_used' => $hostToUse,
        'time' => date('c')
    ];
    file_put_contents($mailboxPath, json_encode($mailbox, JSON_PRETTY_PRINT | JSON_UNESCAPED_UNICODE));
}

render_success('Mail Sent', 'If the user exists, a reset link has been sent to their email.', 'login.html');
?>
