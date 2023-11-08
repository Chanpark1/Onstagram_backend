<?php
error_reporting(E_ALL);
ini_set("display_errors", 1);

include_once 'dbconn.php';

$username = $_POST['username'];

$sql = 
"SELECT username 
FROM User
WHERE username = '$username'
";

$result = mysqli_query($conn, $sql);

$row = mysqli_fetch_assoc($result);

echo isset($row['username']) ? "O" : "X";


?>