<?php
error_reporting(E_ALL);
ini_set("display_errors", 1);

include_once 'dbconn.php';

$phone = $_POST['phone'];
$name = $_POST['name'];
$username = $_POST['username'];
$pw = $_POST['password'];

    $sql = 
    "INSERT INTO User(phone, username, name, password)
    VALUES ('$phone', '$username', '$name','$pw')
    ";

    $sql_query = mysqli_query($conn, $sql);

    $sql_idx = 
    "SELECT idx
    FROM User
    WHERE phone = '$phone'
    ";

    $idx_query = mysqli_query($conn, $sql_idx);

    $idx_result = mysqli_fetch_assoc($idx_query);

    echo $idx_result['idx'];
?>
