<?php
$zhenshiyonghu='admin';
$zhenshimima='Abc123';
require_once __DIR__ . '/../../common/ui.php';
$user=isset($_GET['username']) ? (string)$_GET['username'] : '';
$pass=isset($_GET['password']) ? (string)$_GET['password'] : '';

ob_start();
if ($zhenshiyonghu === $user && $pass === $zhenshimima) {
    render_success('Login Successful', 'Welcome, admin! Your flag is: flag{3f9a7b2c-5d4e-4a8c-9b1f-e7c6a5d8f3b0}', null);
} else {
    render_error('Login Failed','Invalid username or password');
}
$buf = ob_get_clean();
$target = 4096;
$pad = $target - strlen($buf);
if ($pad < 0) { $pad = 0; }
echo $buf . '<!--' . str_repeat('x', $pad) . '-->';
?>
