<?php
error_reporting(E_ALL);
ini_set("display_errors", 1);

include_once 'dbconn.php';

$idx = $_POST['idx_visitor'];

$postIdx = $_POST['postIdx'];

$isLike = $_POST['isLike'];

if($isLike == "+") {
    $sql_like = 
    "UPDATE Post
    SET like_num = like_num + 1
    WHERE idx = '$postIdx'
    ";

    $query_like = mysqli_query($conn, $sql_like);

    $sql_update = 
    "INSERT INTO Post_like(userIdx, postIdx)
    VALUES('$idx','$postIdx')
    ";

    $query_update = mysqli_query($conn, $sql_update);

    $sql =
    "SELECT like_num
    FROM Post
    WHERE idx = '$postIdx'
    ";

    $query = mysqli_query($conn, $sql);

    $row = mysqli_fetch_assoc($query);

    echo $row['like_num'];

} else {

    $sql_dislike = 
    "UPDATE Post
    SET like_num = like_num -1
    WHERE idx = '$postIdx'
    ";

    $query_dislike = mysqli_query($conn, $sql_dislike);

    $sql_delete = 
    "DELETE FROM Post_like
    WHERE postIdx = '$postIdx'
    ";

    $query_delete = mysqli_query($conn, $sql_delete);

    $sql_result = 
    "SELECT like_num
    FROM Post
    WHERE idx = '$postIdx'
    ";

    $query_result = mysqli_query($conn, $sql_result);

    $result = mysqli_fetch_assoc($query_result);
    
    echo $result['like_num'];
}


?>