<?php
header('Content-Type: text/html; charset=utf-8');
$zhenshiyonghu='admin';
$zhenshimima='777777';

$user=$_GET['username'];
$pass=$_GET['password'];

if ($zhenshiyonghu===$user & $pass===$zhenshimima){
    echo "登录成功!";}
else{
    echo "登录失败!";
}

?>