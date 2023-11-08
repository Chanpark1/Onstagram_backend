<?php
error_reporting(E_ALL);
ini_set("display_errors", 1);

include_once 'dbconn.php';

$phone = $_POST['phone'];

$sql = 
"SELECT phone 
FROM User
WHERE phone = '$phone'
";

$result = mysqli_query($conn, $sql);

$row = mysqli_fetch_assoc($result);

echo isset($row['phone']) ? "O" : "X";


?>