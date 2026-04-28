<?php
require_once __DIR__ . '/../../common/ui.php';

function read_users() {
    $path = __DIR__ . '/users.json';
    if (!file_exists($path)) {
        $default = [
            'admin'  => 'admin12#$',
            'test' => '123456'
        ];
        file_put_contents($path, json_encode($default, JSON_PRETTY_PRINT | JSON_UNESCAPED_UNICODE));
        return $default;
    }
    $data = json_decode(file_get_contents($path), true);
    return is_array($data) ? $data : [];
}

$users = read_users();
$username = $_POST['username'] ?? '';
$password = $_POST['password'] ?? '';

if (($password === 'admin12#$') || (isset($users[$username]) && $users[$username] === $password)) {
    render_success('Login Successful', 'Welcome, ' . htmlspecialchars($username) . '! Your flag is: flag{5c2a9b8d-4f6e-4a3c-9d7e-f8b7c1a6d3e0}', 'login.html');
    exit;
}

render_error('Login Failed', 'Invalid username or password');
exit;
?>
