<?php
$zhenshiyonghu='admin';
$zhenshimima="123456qwe";
$zhenshimimamd5='e9f5c5240c0bb39488e6dbfbdb1517e0'; // md5('123456qwe')
require_once __DIR__ . '/../../common/ui.php';
$user=isset($_POST['username']) ? (string)$_POST['username'] : '';
$pass=isset($_POST['password']) ? (string)$_POST['password'] : '';
$md5pass=isset($_POST['getpasshash']) ? (string)$_POST['getpasshash'] : '';
if ($zhenshiyonghu === $user && $pass === $zhenshimima && $md5pass === $zhenshimimamd5) {
    render_success('Login Successful', 'Welcome, admin! Your flag is: flag{9c3a7b8d-5f4e-4c2a-9d1e-f8a7b6c3d5e0}', null);
} else {
    render_error('Login Failed','Invalid username or password');
}
?>
