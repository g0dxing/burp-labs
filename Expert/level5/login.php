<?php
session_start();
require_once __DIR__ . '/../../common/ui.php';

$users = [
    'admin' => 'Apple@123',
];

$storePath = __DIR__ . DIRECTORY_SEPARATOR . 'ip-block.json';
if (!file_exists($storePath)) {
    file_put_contents($storePath, json_encode(new stdClass(), JSON_PRETTY_PRINT | JSON_UNESCAPED_UNICODE));
}

function getClientIp(): string {
    if (!empty($_SERVER['HTTP_X_FORWARDED_FOR'])) {
        $xff = $_SERVER['HTTP_X_FORWARDED_FOR'];
        $parts = explode(',', $xff);
        return trim($parts[0]);
    }
    return $_SERVER['REMOTE_ADDR'] ?? '0.0.0.0';
}

function loadStore(string $path): array {
    $raw = file_get_contents($path);
    $data = json_decode($raw, true);
    return is_array($data) ? $data : [];
}

function saveStore(string $path, array $data): void {
    file_put_contents($path, json_encode($data, JSON_PRETTY_PRINT | JSON_UNESCAPED_UNICODE));
}

if ($_SERVER['REQUEST_METHOD'] !== 'POST') {
    render_error('方法不被允许', '仅支持 POST 登录请求', 'login.html');
    exit;
}

$username = isset($_POST['username']) ? trim((string)$_POST['username']) : '';
$password = isset($_POST['password']) ? (string)$_POST['password'] : '';

if ($username === '' || $password === '') {
    render_error('Login Failed', 'Invalid username or password');
    exit;
}

$ip = getClientIp();
$store = loadStore($storePath);
$now = time();
$windowSeconds = 600; 
$maxFailures = 5;     

if (!isset($store[$ip])) {
    $store[$ip] = [ 'count' => 0, 'blocked_until' => 0, 'updated_at' => $now ];
}

if (($now - (int)$store[$ip]['updated_at']) > $windowSeconds) {
    $store[$ip]['count'] = 0;
    $store[$ip]['updated_at'] = $now;
    $store[$ip]['blocked_until'] = 0;
}

if ((int)$store[$ip]['blocked_until'] > $now) {
    render_error('Access Denied', '当前 IP 封禁中，请稍后再试');
    exit;
}

if (!array_key_exists($username, $users) || !hash_equals($users[$username], $password)) {
    $store[$ip]['count'] = (int)$store[$ip]['count'] + 1;
    $store[$ip]['updated_at'] = $now;
    if ($store[$ip]['count'] >= $maxFailures) {
        $store[$ip]['blocked_until'] = $now + 120;
    }
    saveStore($storePath, $store);
    render_error('Login Failed', 'Invalid username or password');
    exit;
}

$store[$ip]['count'] = 0;
$store[$ip]['blocked_until'] = 0;
$store[$ip]['updated_at'] = $now;
saveStore($storePath, $store);

$_SESSION['user'] = $username;
render_success('Login Successful', 'Welcome, ' . htmlspecialchars($username) . '! Your flag is: flag{9b2c7a8d-4f6e-4a3c-9d5e-f7b8c1a6d3e0}', 'login.html');
exit;
?>
