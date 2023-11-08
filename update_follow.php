<?php
 error_reporting(E_ALL);
 ini_set("display_errors", 1);
 
 include_once 'dbconn.php';

$idx_visitor = $_POST['idx_visitor'];
$idx_master = $_POST['idx_master'];

$sql_follow =
"INSERT INTO Follow(userIdx, following)
VALUES ('$idx_visitor', '$idx_master')
";

$query_follow = mysqli_query($conn, $sql_follow);

$sql = 
"SELECT idx 
FROM Follow
WHERE userIdx = '$idx_visitor'
AND following = '$idx_master'
";

$query = mysqli_query($conn, $sql);

$row = mysqli_fetch_assoc($query);

if(isset($row['idx'])) {
    echo "O";
} else {
    echo "X";
}

?>