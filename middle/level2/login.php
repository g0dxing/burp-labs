<?php
$zhenshiyonghu='admin';
$zhenshimima='YWRtaW5pc3RyYXRvcg=='; // base64 encoded 'administrator'
require_once __DIR__ . '/../../common/ui.php';
$user=isset($_POST['username']) ? (string)$_POST['username'] : '';
$pass=isset($_POST['password']) ? (string)$_POST['password'] : '';
if ($zhenshiyonghu === $user && $pass === $zhenshimima) {
    render_success('Login Successful', 'Welcome, admin! Your flag is: flag{a2b7c9d4-3e6f-4a8c-9d1b-f7e8c5a3b6d0}', null);
} else {
    render_error('Login Failed','Invalid username or password');
}
?>
