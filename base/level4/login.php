<?php
$zhenshiyonghu='test';
$zhenshimima='123456789';

$user=$_GET['username'];
$pass=$_GET['password'];

if ($zhenshiyonghu===$user){
    if ($pass===$zhenshimima){
        echo "login success!";
    }
    else{
        echo "    login error!!!";
    }

}
else{
    echo 'oh! username error';
}
?>