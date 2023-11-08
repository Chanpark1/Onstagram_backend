<?php
error_reporting(E_ALL);
ini_set("display_errors", 1);

include_once 'dbconn.php';

$idx = $_POST['idx'];

$data = array();

$image = array();


$isLike = null;

// user data

$sql_user = 
"SELECT idx, username, profileImage
FROM User
WHERE idx = '$idx'
";

$query_user = mysqli_query($conn, $sql_user);

while($row_user = mysqli_fetch_assoc($query_user)) {
// profile data

$sql_post =
"SELECT *
FROM Post
WHERE userIdx = '$idx'
";

$query_post = mysqli_query($conn, $sql_post);

while($row_post = mysqli_fetch_assoc($query_post)) {

    $post_idx = $row_post['idx'];

    $sql_image =
    "SELECT path
    FROM Image_post
    WHERE postIdx = '$post_idx'
    ";

    $query_image = mysqli_query($conn, $sql_image);

    while($row_image = mysqli_fetch_assoc($query_image)) {
    
        array_push($image, 
        array('image' => $row_image['path'])
        );
        
    };

    $sql_isLike = 
    "SELECT idx
    FROM Post_like
    WHERE userIdx = '$idx'
    AND postIdx = '$post_idx'
    ";

    $query_isLike = mysqli_query($conn, $sql_isLike);

    $isLike = mysqli_fetch_assoc($query_isLike);

    if(isset($isLike['idx'])) {
        $isLike = "O";
    } else {
        $isLike = "X";
    }
    
array_push($data, 
    array('userIdx' => $row_user['idx'],
    'userImage' => $row_user['profileImage'],
    'username' => $row_user['username'],
    'postIdx' => $post_idx,
    'image_path' => $image,
    'content' => $row_post['content'],
    'like_num' => $row_post['like_num'],
    'isLike' => $isLike
));

$json = json_encode($data, JSON_PRETTY_PRINT + JSON_UNESCAPED_UNICODE);

$image = array();
}
}



echo $json;


















?>