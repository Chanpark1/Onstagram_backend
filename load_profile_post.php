<?php
error_reporting(E_ALL);
ini_set("display_errors", 1);

include_once 'dbconn.php';

$idx = $_POST['idx'];

$sql = 
"SELECT idx
FROM Post
WHERE userIdx = '$idx'
";

$result = mysqli_query($conn, $sql);

$data = array();


while($row = mysqli_fetch_assoc($result)) {

    $postIdx = $row['idx'];

    $sql_image = 
    "SELECT path 
    FROM Image_post
    WHERE postIdx = '$postIdx'
    ORDER BY idx ASC
    LIMIT 1
    ";
    
    $result_image = mysqli_query($conn, $sql_image);
    $rows = mysqli_fetch_assoc($result_image);

    $sql_num = 
    "SELECT path
    FROM Image_post
    WHERE postIdx = '$postIdx'
    ";

    $query_num = mysqli_query($conn, $sql_num);
    
    $rows_num = $query_num -> num_rows;

    array_push($data,
    array(
            'postIdx' => $postIdx,
            'thumbnail' => $rows['path'],
            'image_num' => $rows_num,
            'idx' => $idx
        ));
        $json = json_encode($data, JSON_PRETTY_PRINT + JSON_UNESCAPED_UNICODE);
        
};

echo $json;







?>