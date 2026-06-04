<?php

header('Content-Type: application/json; charset=utf-8');

$baseDir = __DIR__;
$usersPath = $baseDir . '/users.json';
$ratePath  = $baseDir . '/rate.json';

function read_json($path, $fallback) {
    if (!file_exists($path)) { return $fallback; }
    $data = json_decode(file_get_contents($path), true);
    return is_array($data) ? $data : $fallback;
}

function write_json($path, $data) {
    file_put_contents($path, json_encode($data, JSON_PRETTY_PRINT | JSON_UNESCAPED_UNICODE));
}

$raw = file_get_contents('php://input');
$payload = json_decode($raw, true);
if (!is_array($payload)) { $payload = []; }

$username = $payload['username'] ?? '';
$password = $payload['password'] ?? '';

$users = read_json($usersPath, [ 'wiener' => 'peter', 'carlos' => 'qwerty', 'admin' => 'admin123' ]);
$rate  = read_json($ratePath, []);
$rate[$username] = ($rate[$username] ?? 0) + 1;
write_json($ratePath, $rate);

if (($rate[$username] ?? 0) > 50) {
    http_response_code(429);
    echo json_encode(['error' => 'Too many attempts']);
    exit;
}

$valid = false;
if (is_array($password)) {
    foreach ($password as $candidate) {
        if (isset($users[$username]) && $users[$username] === $candidate) {
            $valid = true;
            break;
        }
    }
} else {
    if (isset($users[$username]) && $users[$username] === $password) {
        $valid = true;
    }
}

if ($valid) {
    setcookie('lab33_user', $username, time() + 3600, '/');
    header('Location: account.php', true, 302);
    echo json_encode(['redirect' => 'account.php', 'status' => 'ok']);
    exit;
}

http_response_code(200);
echo json_encode(['error' => 'Invalid credentials']);