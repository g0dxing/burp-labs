<?php
$zhenshiyonghu='admin';
$zhenshimima='P@ssw0rd';
$user=isset($_GET['username']) ? (string)$_GET['username'] : '';
$pass=isset($_GET['password']) ? (string)$_GET['password'] : '';

$known = ($user === $zhenshiyonghu);
$success = ($known && $pass === $zhenshimima);
require_once __DIR__ . '/../../common/ui.php';
ob_start();
if ($success) {
    render_success('Login Successful', 'Welcome, admin! Your flag is: flag{8a4c7f2d-1b6e-4f3a-9c25-e8d7f6a3b0c1}', null);
} else if ($known) {
    render_error('Login Failed','Password incorrect', 'login.html', 200);
} else {
    render_error('Login Failed','Invalid username or password', 'login.html', 200);
}
$buf = ob_get_clean();
if ($success) {
    $target = 3072;
} else if ($known) {
    $target = 3584;
} else {
    $target = 4096;
}
$pad = $target - strlen($buf);
if ($pad < 0) { $pad = 0; }
echo $buf . '<!--' . str_repeat('x', $pad) . '-->';
?>
