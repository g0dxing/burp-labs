<?php
$zhenshiyonghu='admin';
$zhenshimima='godxing@123456';

$user=$_POST['username'];
$pass=$_POST['password'];

if ($zhenshiyonghu===$user & $pass===$zhenshimima){
    echo "login success!";
}
else{
    echo "login error!!!";
}

?>