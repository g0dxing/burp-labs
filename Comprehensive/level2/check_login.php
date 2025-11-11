<?php
// check_login.php
require_once 'check_auth.php';

$status = checkLoginStatus();
header('Content-Type: application/json');
echo json_encode($status);
?>