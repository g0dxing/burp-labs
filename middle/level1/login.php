<?php
$zhenshiyonghu = 'admin';
$zhenshimima = 'password1!';

require_once __DIR__ . '/../../common/ui.php';
$user = isset($_POST['username']) ? (string)$_POST['username'] : '';
$pass = isset($_POST['password']) ? (string)$_POST['password'] : '';

$success = ($zhenshiyonghu === $user && $pass === $zhenshimima);
http_response_code(302);
header('Location: ' . ($success ? '/middle/level1/welcome.php' : '/middle/level1/login.html'));
$target = 2048;
echo str_repeat('x', $target);
exit;
?>
