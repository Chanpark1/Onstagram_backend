<?php
error_reporting(E_ALL);
ini_set("display_errors", 1);

include_once 'dbconn.php';

$idx = $_POST['idx'];
$email = $_POST['email'];

$sql_duplicate = 
"SELECT email
FROM User
WHERE email = '$email'
";

$result_dup = mysqli_query($conn, $sql_duplicate);
$row_dup = mysqli_fetch_assoc($result_dup);

if(isset($row_dup['email'])) {
    echo "Duplicate";
} else {
    $sql = 
    "UPDATE User
    SET email = '$email'
    WHERE idx = '$idx'
    ";
    
    if($result = mysqli_query($conn, $sql)) {
        echo "Success";
    } else { 
        echo "Fail";
    }
}





?>