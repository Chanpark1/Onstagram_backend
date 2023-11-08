<?php
error_reporting(E_ALL);
ini_set("display_errors", 1);

include_once 'dbconn.php';

$idx = $_POST['idx_master'];

$sql_user = 
"SELECT idx, username, name, profileImage, content, isLocked FROM User
WHERE idx = '$idx'
";

$sql_follower = 
"SELECT idx FROM Follow
WHERE userIdx = '$idx'
";

$query_follower = $conn -> query($sql_follower);

$result_follower = $query_follower -> num_rows;

$sql_following = 
"SELECT idx FROM Follow
WHERE following = '$idx'
";

$query_following = $conn -> query($sql_following);

$result_following = $query_following -> num_rows;

$sql_post = 
"SELECT * FROM Post
WHERE userIdx = '$idx'
";

$query_post = $conn -> query($sql_post);

$result_post = $query_post -> num_rows;


$query_user = mysqli_query($conn, $sql_user);

$result_user = mysqli_fetch_assoc($query_user);

$data = array(
    'username' => $result_user['username'],
    'name' => $result_user['name'],
    'profileImage' => $result_user['profileImage'],
    'content' => $result_user['content'],
    'isLocked' => $result_user['isLocked'],
    'follower_num' => $result_follower,
    'following_num' => $result_following,
    'post_num' => $result_post,
    'isFollower' => null
);

$json = json_encode($data, JSON_PRETTY_PRINT + JSON_UNESCAPED_UNICODE);
echo $json;
?>