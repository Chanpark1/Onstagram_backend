<?php
error_reporting(E_ALL);
ini_set("display_errors", 1);

include_once 'dbconn.php';

$idx = $_POST['idx'];

$sql =
"SELECT isLocked
FROM User
WHERE idx = '$idx'
";

$query = mysqli_query($conn, $sql);

$row = mysqli_fetch_assoc($query);


echo $row['isLocked'];
?>