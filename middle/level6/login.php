<?php
$zhenshiyonghu='admin';
$zhenshimima='777777';

$user=$_GET['username'];
$pass=$_GET['password'];

if ($zhenshiyonghu===$user & $pass===$zhenshimima){
    echo "欢迎登录，管理员!";
}
else{
    echo "登录失败!!!";
}

?>