<?php
include_once('mysql_access.php');
date_default_timezone_set('UTC');

$phone = $_GET['phone'];

$con = mysqli_connect($mysql_access['host'],$mysql_access['user'],$mysql_access['pass'],$mysql_access['db']);
// Check connection
if (mysqli_connect_errno()){
    response("{'connection error'}", $con);
}

$result = mysqli_query($con, "SELECT * FROM scheduled_msgs WHERE `from`='$phone' AND sent_msg!=1 ORDER BY `send` LIMIT 1");
$data = array();
if(!$result){
    response("{'query error'}", $con);
}else{
    $data = mysqli_fetch_array($result);
}


if(empty($data)){
    response("{'no data'}", $con);
}

if(strtotime($data['send']) <= strtotime("now")){
    $id = $data['id'];
    mysqli_query($con, "UPDATE scheduled_msgs SET sent_msg=1 WHERE id='$id'");
    response(json_encode($data), $con);
}else{
    response('{}', $con);
}

function response($text, $connection){
    echo $text;
    mysqli_close($connection);
    exit;
}
?>