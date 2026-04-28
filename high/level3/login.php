<?php
$zhenshiyonghu='admin';
$zhenshimima="Qwert12345";
$xianzaiTimestamp=time();

$user=isset($_POST['username']) ? (string)$_POST['username'] : '';
$pass=isset($_POST['password']) ? (string)$_POST['password'] : '';
$Timestamp=isset($_POST['_Timestamp']) ? (int)$_POST['_Timestamp'] : 0;
require_once __DIR__ . '/../../common/ui.php';

$difference = abs($xianzaiTimestamp - $Timestamp);
if($difference < 3){
    if ($zhenshiyonghu === $user && $pass === $zhenshimima ){
        render_success('Login Successful', 'Welcome, admin! Your flag is: flag{d3a8b7c9-5f6e-4a2c-9e1d-f8b7c5a3d6e0}', null);
    } else {
        render_error('Login Failed','Invalid username or password');
    }
} else {
    render_error('Request Timeout','Request timed out', 'login.html', 200);
}
?>
