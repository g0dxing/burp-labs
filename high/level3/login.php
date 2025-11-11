<?php
$zhenshiyonghu='admin';
$zhenshimima="789632145";
$xianzaiTimestamp=time();

$user=$_POST['username'];
$pass=$_POST['password'];
$Timestamp=$_POST['_Timestamp'];


$difference = abs($xianzaiTimestamp - $Timestamp);
if($difference < 3){
    if ($zhenshiyonghu===$user & $pass===$zhenshimima ){
        echo "欢迎登录，管理员!";
    }
    else{
        echo "登录失败!!!";
    }
}
else{
    echo "请求超时！";
    header("Location: login.html");
    exit;
}
?>