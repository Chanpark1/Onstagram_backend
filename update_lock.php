<?php
error_reporting(E_ALL);
ini_set("display_errors", 1);

include_once 'dbconn.php';

$idx = $_POST['idx'];
$val = $_POST['lock'];

$res = null;

$sql = 
"UPDATE User
SET isLocked = '$val'
WHERE idx = '$idx'
";

if($query = mysqli_query($conn, $sql)) {
    $res = "O";
    
    echo $res;
} else {
    $res = "X";

    echo $res;
};

?>