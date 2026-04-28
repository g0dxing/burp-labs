<?php
$zhenshiyonghu='admin';
$zhenshimima='godxing@pass@123';
require_once __DIR__ . '/../../common/ui.php';
$user=isset($_POST['username']) ? (string)$_POST['username'] : '';
$pass=isset($_POST['password']) ? (string)$_POST['password'] : '';
if ($zhenshiyonghu === $user && $pass === $zhenshimima) {
    render_success('Login Successful', 'Welcome, admin! Your flag is: flag{2b6d9a7c-4f8e-4a3c-9d1f-e7b8c5a6f3d0}', null);
} else {
    render_error('Login Failed','Invalid username or password');
}
?>
