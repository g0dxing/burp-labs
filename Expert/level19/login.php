<?php
$zhenshiyonghu='admin';
$zhenshimima='38e27dd94f836975cc3dc664ff8742f5';//abc123456789的md5编码，g0dxing加盐,加盐模式：hmac
$user=$_POST['username'];
$pass=$_POST['password'];

if ($zhenshiyonghu===$user & $pass===$zhenshimima){
    echo "欢迎登录，管理员!";
}
else{
    echo "登录失败!!!";
}

?>
