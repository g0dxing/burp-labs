<?php
$zhenshiyonghu='admin';
$zhenshimima='TE9WRTUyMDEzMTQ=';//LOVE5201314的base64编码

$user=$_POST['username'];
$pass=$_POST['password'];

if ($zhenshiyonghu===$user & $pass===$zhenshimima){
    echo "欢迎登录，管理员!";
}
else{
    echo "登录失败!!!";
}

?>