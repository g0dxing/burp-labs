<?php
$zhenshiyonghu = 'admin';
$zhenshimima = 'admin@123';

$user = $_POST['username'];
$pass = $_POST['password'];

if ($zhenshiyonghu === $user && $pass === $zhenshimima) {
    header("Location: welcome.html");
    exit;
} else {
    echo "login tmd tmd funck error!";
}
?>