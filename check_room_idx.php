<?php
error_reporting(E_ALL);
ini_set("display_errors", 1);

include_once 'dbconn.php';

$room_idx = $_POST['room_idx'];
$sender_idx = $_POST['sender_idx'];

$s_check = 
"SELECT CRM.user_idx, U.username
FROM chat_room_members AS CRM
JOIN User AS U ON CRM.user_idx = U.idx
WHERE CRM.chat_room_idx = '$room_idx'
AND CRM.user_idx = '$sender_idx'
";

$stmt = $conn -> prepare($s_check);

$stmt -> bind_param("ss", $room_idx, $sender_idx);
$stmt -> execute();

$result = $stmt -> get_result();

$row = $result -> fetch_assoc();

$username = $row['username'];

echo $username;


?>