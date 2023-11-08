<?php
error_reporting(E_ALL);
ini_set("display_errors", 1);

include_once 'dbconn.php';

$idx = $_POST['idx'];

$data = array();

$image = array();

$isLike = null;

// 팔로잉 체크

$sql_following = 
"SELECT following
FROM Follow
WHERE userIdx = '$idx'
";

$query_following = mysqli_query($conn, $sql_following);

while($following = mysqli_fetch_assoc($query_following)) {
    $following_idx = $following['following'];
    
    //userdata

    $sql_user = 
    "SELECT idx, username, profileImage
    FROM User
    WHERE idx = '$following_idx'
    ";

    $query_user = mysqli_query($conn, $sql_user);

    while($user = mysqli_fetch_assoc($query_user)) {
        $userIdx = $user['idx'];

        $sql_post = 
        "SELECT *
        FROM Post
        WHERE userIdx = '$userIdx'
        ";

        $query_post = mysqli_query($conn, $sql_post);

        while($post = mysqli_fetch_assoc($query_post)) {

            $postIdx = $post['idx'];

            $sql_image = 
            "SELECT path
            FROM Image_post
            WHERE postIdx = '$postIdx'
            ";

            $query_image = mysqli_query($conn, $sql_image);

            while($row_image = mysqli_fetch_assoc($query_image)) {

                array_push($image, 
                array('image' => $row_image['path']
                ));

            }

            $sql_isLike = 
            "SELECT idx
            FROM Post_like
            WHERE userIdx = '$idx'
            AND postIdx = '$postIdx'
            ";

            $query_isLike = mysqli_query($conn, $sql_isLike);

            $isLike = mysqli_fetch_assoc($query_isLike);
                if(isset($isLike['idx'])) {
                    $isLike = "O";
                } else {
                    $isLike = "X";
                }
            

            array_push($data,
            array('userIdx' => $user['idx'],
            'userImage' => $user['profileImage'],
            'username' => $user['username'],
            'postIdx' => $postIdx,
            'image_path' => $image,
            'content' => $post['content'],
            'like_num' => $post['like_num'],
            'isLike' => $isLike));

            $json = json_encode($data, JSON_PRETTY_PRINT + JSON_UNESCAPED_UNICODE);

            $image = array();
            };
    }
}

echo $json;

// $sql = 
// "SELECT U.idx AS userIdx, U.username, U.profileImage, P.idx AS postIdx, P.content, P.like_num, IP.path AS image_path
// FROM Follow F
// INNER JOIN User U ON F.following = U.idx
// INNER JOIN Post P ON U.idx = P.userIdx
// LEFT JOIN Image_post IP ON P.idx = IP.postIdx
// WHERE F.userIdx = '$idx'
// ";

// $query = mysqli_query($conn, $sql);

// $row = mysqli_fetch_assoc($query);

// while ($row = mysqli_fetch_assoc($query)) {
//     $userIdx = $row['userIdx'];
//     $postIdx = $row['postIdx'];

//     $image = array('image_path' => $row['image_path']);

//     if(!isset($userData[$userIdx])) {
//         $userData[$userIdx] = array(
//             'userIdx' => $userIdx,
//             'userImage' => $row['profileImage'],
//             'username' => $row['username'],
//             'posts' => array()
//         );
//     }

//     if(!isset($userData[$userIdx]['posts']['postIdx'])) {
//         $userData[$userIdx]['posts']['postIdx'] = array(
//             'postIdx' => $postIdx,
//             'content' => $row['content'],
//             'like_num' => $row['like_num'],
//             'image_path' => array());
//     }

//     if($row['image_path']) {
//         $userData[$userIdx]['posts']['postIdx']['image_path'][] = $row['image_path'];
//     }

// }

// $jsonData = array_values($userData);

// $json = json_encode($jsonData, JSON_PRETTY_PRINT + JSON_UNESCAPED_UNICODE);

// echo $json;

?>
