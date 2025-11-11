<?php
$zhenshiyonghu='admin';
$zhenshimima='123456789';

$user=$_GET['username'];
$pass=$_GET['password'];

if ($zhenshiyonghu===$user){
    if ($pass===$zhenshimima){
        echo "login success";
    }
    else{
        echo "password error";
    }

}
else{
    echo 'username error';
}
?>