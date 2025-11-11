<?php
$zhenshiyonghu='admin';
$zhenshimima='password';

$user=$_GET['username'];
$pass=$_GET['password'];

if ($zhenshiyonghu===$user){
    if ($pass===$zhenshimima){
        echo "login success!";
    }
    else{
        echo "login error!!!";
    }

}
else{
    echo 'username error';
}
?>