<?php
$zhenshiyonghu='admin';
$zhenshimima='59dacbeb78e466f83d96fddb9aa00665';//12345677654321的md5编码，godxing加盐,加盐模式：盐+文本
$user=$_POST['username'];
$pass=$_POST['password'];

if ($zhenshiyonghu===$user & $pass===$zhenshimima){
    echo "欢迎登录，管理员!";
}
else{
    echo "登录失败!!!";
}

?>
