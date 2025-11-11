<?php
$zhenshiyonghu='admin';
$zhenshimima='123456789';

$user=$_POST['username'];
$pass=$_POST['password'];

if ($zhenshiyonghu===$user & $pass===$zhenshimima){
    echo "login success!";
}
else{
    echo "login error!!!";
}

?>