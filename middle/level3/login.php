<?php
$zhenshiyonghu='admin';
$zhenshimima='8068c76c7376bc08e2836ab26359d4a4'; // md5('qweasd123')
require_once __DIR__ . '/../../common/ui.php';
$user=isset($_POST['username']) ? (string)$_POST['username'] : '';
$pass=isset($_POST['password']) ? (string)$_POST['password'] : '';
if ($zhenshiyonghu === $user && $pass === $zhenshimima) {
    render_success('Login Successful', 'Welcome, admin! Your flag is: flag{4d8f6a9c-3b7e-4a2c-9d1f-e8c7b5a3f6d0}', null);
} else {
    render_error('Login Failed','Invalid username or password');
}
?>
