<?php
include_once('mysql_access.php');
date_default_timezone_set('UTC');

$json = file_get_contents('php://input');
$data = json_decode($json, true);

$msg = $data['msg'];
$phone = $data['phone'];
$from = $data['from'];
$send = date('Y-m-d H:i:s', strtotime($data['send']));
$now = date('Y-m-d H:i:s');

$con = mysqli_connect($mysql_access['host'],$mysql_access['user'],$mysql_access['pass'],$mysql_access['db']);
// Check connection
if (mysqli_connect_errno()){
    response($con, 0);
}

try{
    mysqli_query($con, "INSERT INTO scheduled_msgs (`msg`, `phone`, `from`, `send`, `stamp`) VALUES ('$msg', '$phone', '$from', '$send', '$now')");
}catch(Exception $e){
    response($con, 0);
}
response($con, 1);

function response($connection, $r){
    mysqli_close($connection);
    echo $r;
    exit;
}
?>