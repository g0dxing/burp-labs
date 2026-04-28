<?php
$zhenshiyonghu='admin';
$zhenshimima='test';
require_once __DIR__ . '/../../common/ui.php';
$user=isset($_POST['username']) ? (string)$_POST['username'] : '';
$pass=isset($_POST['password']) ? (string)$_POST['password'] : '';
if ($zhenshiyonghu === $user && $pass === $zhenshimima) {
    render_success('Login Successful', 'Welcome, admin! Your flag is: flag{ebdfea9b-3469-41c7-9070-d7833ecc6102}', null);
} else {
    render_error('Login Failed','Invalid username or password');
}
?>
