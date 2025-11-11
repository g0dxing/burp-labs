<?php
$zhenshiyonghu='admin';
$zhenshimima='1bbd886460827015e5d605ed44252251';//11111111的md5编码

$user=$_POST['username'];
$pass=$_POST['password'];

if ($zhenshiyonghu===$user & $pass===$zhenshimima){
    echo "欢迎登录，管理员!";
}
else{
    echo "登录失败!!!";
}

?>