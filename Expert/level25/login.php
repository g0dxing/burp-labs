<?php
// Level 27: Broken brute-force protection, IP block
// 演示按 IP 计数封禁，但信任 X-Forwarded-For 导致可通过修改该头绕过
session_start();

$users = [
    'wiener' => 'peter',
    'administrator' => 'Admin!23',
];

$storePath = __DIR__ . DIRECTORY_SEPARATOR . 'ip-block.json';
if (!file_exists($storePath)) {
    file_put_contents($storePath, json_encode(new stdClass(), JSON_PRETTY_PRINT | JSON_UNESCAPED_UNICODE));
}

function getClientIp(): string {
    // 漏洞点：优先信任 X-Forwarded-For，并取第一个（可由攻击者控制）
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

function renderError(string $message): void {
    echo '<!DOCTYPE html><html lang="zh-CN">';
    echo '<head><meta charset="utf-8"><meta name="viewport" content="width=device-width, initial-scale=1.0">';
    echo '<title>登录失败</title>';
    echo '<style>body{font-family:-apple-system,BlinkMacSystemFont,\'Segoe UI\',Roboto,Arial,sans-serif;display:grid;place-items:center;min-height:100vh;background:#0f172a;color:#e5e7eb;margin:0}';
    echo '.card{width:360px;max-width:92vw;background:#111827;border:1px solid #374151;border-radius:12px;padding:24px;box-shadow:0 10px 25px rgba(0,0,0,.35)}';
    echo '.msg{margin:0 0 12px;font-size:1rem;color:#fca5a5}a{color:#93c5fd}</style></head><body>';
    echo '<div class="card">';
    echo '<h1 style="margin:0 0 8px;font-size:1.25rem;">登录失败</h1>';
    echo '<p class="msg">' . htmlspecialchars($message, ENT_QUOTES | ENT_SUBSTITUTE, 'UTF-8') . '</p>';
    echo '<p><a href="login.html">返回登录页</a></p>';
    echo '</div></body></html>';
}

if ($_SERVER['REQUEST_METHOD'] !== 'POST') {
    http_response_code(405);
    renderError('仅支持 POST 登录请求');
    exit;
}

$username = isset($_POST['username']) ? trim((string)$_POST['username']) : '';
$password = isset($_POST['password']) ? (string)$_POST['password'] : '';

if ($username === '' || $password === '') {
    http_response_code(400);
    renderError('账号或密码错误');
    exit;
}

$ip = getClientIp();
$store = loadStore($storePath);
$now = time();
$windowSeconds = 600; // 10 分钟窗口
$maxFailures = 5;     // 失败次数上限

if (!isset($store[$ip])) {
    $store[$ip] = [ 'count' => 0, 'blocked_until' => 0, 'updated_at' => $now ];
}

// 过期窗口重置计数
if (($now - (int)$store[$ip]['updated_at']) > $windowSeconds) {
    $store[$ip]['count'] = 0;
    $store[$ip]['updated_at'] = $now;
    $store[$ip]['blocked_until'] = 0;
}

// 若已被封禁
if ((int)$store[$ip]['blocked_until'] > $now) {
    http_response_code(429);
    renderError('当前 IP 封禁中，请稍后再试');
    exit;
}

// 校验用户名与密码
if (!array_key_exists($username, $users) || !hash_equals($users[$username], $password)) {
    $store[$ip]['count'] = (int)$store[$ip]['count'] + 1;
    $store[$ip]['updated_at'] = $now;
    if ($store[$ip]['count'] >= $maxFailures) {
        // 封禁 2 分钟
        $store[$ip]['blocked_until'] = $now + 120;
    }
    saveStore($storePath, $store);
    http_response_code(401);
    // 统一错误信息，避免通过文案枚举
    renderError('账号或密码错误');
    exit;
}

// 登录成功：重置当前 IP 的失败计数
$store[$ip]['count'] = 0;
$store[$ip]['blocked_until'] = 0;
$store[$ip]['updated_at'] = $now;
saveStore($storePath, $store);

$_SESSION['user'] = $username;
header('Location: welcome.html');
exit;