<?php
error_reporting(E_ALL);
ini_set("display_errors", 1);

include_once 'dbconn.php';
//이걸 뜯어 고쳐야함.
$idx_master = $_POST['idx_master'];

$idx_visitor = $_POST['idx_visitor'];

$sql_info = 
"SELECT idx, username, name, profileImage, content, isLocked 
FROM User
WHERE idx = '$idx_master'
";

$query_info = mysqli_query($conn, $sql_info);

$info = mysqli_fetch_assoc($query_info);


// 해당 계정이 비공개 계정일 경우

    // 해당 계정이 사용자 계정을 팔로우 하는 경우

    $sql_follower = 
    "SELECT following
    FROM Follow
    WHERE following = '$idx_master'
    ";

    $query_follower = $conn -> query($sql_follower);

    $result_follower = $query_follower -> num_rows;

    $sql_following =
    "SELECT following
    FROM Follow
    WHERE userIdx = '$idx_master'
    ";

    $query_following = $conn -> query($sql_following);

    $result_following = $query_following -> num_rows;

    $sql_post =
    "SELECT idx
    FROM Post
    WHERE userIdx = '$idx_master'
    ";

    $query_post = $conn -> query($sql_post);

    $result_post = $query_post -> num_rows;

    $sql_isFollower =
    "SELECT idx
    FROM Follow
    WHERE userIdx = '$idx_visitor'
    AND following = '$idx_master'
    ";

    $query_isFollower = mysqli_query($conn, $sql_isFollower);

    $result_isFollower = mysqli_fetch_assoc($query_isFollower);

    if(isset($result_isFollower['idx'])) {
        $isFollower = "O";
    } else {
        $isFollower = "X";
    }

    $data = array(
        'username' => $info['username'],
        'name' => $info['name'],
        'profileImage' => $info['profileImage'],
        'content' => $info['content'],
        'isLocked' => $info['isLocked'],
        'follower_num' => $result_follower,
        'following_num' => $result_following,
        'post_num' => $result_post,
        'isFollower' => $isFollower
    );
    $json = json_encode($data, JSON_PRETTY_PRINT + JSON_UNESCAPED_UNICODE);

    echo $json;


?>