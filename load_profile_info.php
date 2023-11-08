<?php
error_reporting(E_ALL);
ini_set("display_errors", 1);

include_once 'dbconn.php';

$idx = $_POST['idx'];

$sql = 
" SELECT * FROM User WHERE idx = '$idx'";

$result = mysqli_query($conn, $sql);

$row = mysqli_fetch_assoc($result);

$data = array(
    'idx' => $row['idx'],
    'username' => $row['username'],
    'name' => $row['name'],
    'profileImage' => $row['profileImage']
);
$json = json_encode($data, JSON_PRETTY_PRINT + JSON_UNESCAPED_UNICODE);


echo $json;




?>