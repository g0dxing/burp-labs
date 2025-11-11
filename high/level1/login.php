<?php
$zhenshiyonghu='admin';
$zhenshimima="abc123456";
$zhenshimimamd5='0659c7992e268962384eb17fafe88364';//abc123456的md5编码

$user=$_POST['username'];
$pass=$_POST['password'];
$md5pass=$_POST['getpasshash'];
if ($zhenshiyonghu===$user & $pass===$zhenshimima & $md5pass===$zhenshimimamd5){
    echo "欢迎登录，管理员!";
}
else{
    echo "登录失败!!!";
}

?>