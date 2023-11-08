<?php
error_reporting(E_ALL);
ini_set("display_errors", 1);

include_once 'dbconn.php';

$idx_master = $_POST['idx_master'];
$idx_visitor = $_POST['idx_visitor'];


$sql_isLocked =
"SELECT isLocked
FROM User
WHERE idx = '$idx_master'
";

$query_isLocked = mysqli_query($conn, $sql_isLocked);

$isLocked = mysqli_fetch_assoc($query_isLocked);


$sql_follow = 
"SELECT userIdx
FROM Follow
WHERE userIdx = '$idx_visitor'
AND following = '$idx_master'
";

$query_follow = mysqli_query($conn, $sql_follow);
$follow = mysqli_fetch_assoc($query_follow);

if(isset($follow['userIdx'])) {
    $data = array(
        'isLocked' => $isLocked['isLocked'],
        'isFollower' => "O"
    );
} else {
    $data = array(
        'isLocked' => $isLocked['isLocked'],
        'isFollower' => "X"
    );
}

$json = json_encode($data, JSON_PRETTY_PRINT + JSON_UNESCAPED_UNICODE);

echo $json;


?>