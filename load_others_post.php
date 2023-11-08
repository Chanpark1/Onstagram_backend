<?php
error_reporting(E_ALL);
ini_set("display_errors", 1);

include_once 'dbconn.php';

$idx_master = $_POST['idx_master'];

$idx_visitor = $_POST['idx_visitor'];

//일단 계정 공개 여부 먼저

$sql =
"SELECT isLocked
FROM User
WHERE idx = '$idx_master'
";

$data = array();

$result = mysqli_query($conn, $sql);

$row = mysqli_fetch_assoc($result);

$code = $row['isLocked'];

if($code == 1) {
    $sql_follow = 
    "SELECT idx
    FROM Follow
    WHERE userIdx = '$idx_visitor'
    AND following = '$idx_master'
    ";

    $result_follow = mysqli_query($conn, $sql_follow);

    $rows = mysqli_fetch_assoc($result_follow);

    if(isset($rows['idx'])) {
        
        $sql_post =
        "SELECT idx
        FROM Post
        WHERE userIdx = '$idx_master'
        ";

        $query = mysqli_query($conn, $sql_post);

        while($result = mysqli_fetch_assoc($query)) {
            $postIdx = $result['idx'];

            $sql_image = 
            "SELECT path
            FROM Image_post
            WHERE postIdx = '$postIdx'
            ORDER BY idx ASC
            LIMIT 1
            ";

            $query_image = mysqli_query($conn, $sql_image);
            $result_image = mysqli_fetch_assoc($query_image);

            $sql_num =
            "SELECT path
            FROM Image_post
            WHERE postIdx = '$postIdx'
            ";

            $query_num = mysqli_query($conn, $sql_num);

            $num_row = $query_num -> num_rows;

            array_push($data, 
            array(
                'postIdx' => $postIdx,
                'thumbnail' => $result_image['path'],
                'image_num' => $num_row,
                'idx' => $idx_master
            ));

            $json = json_encode($data, JSON_PRETTY_PRINT + JSON_UNESCAPED_UNICODE);
        }

        echo $json;
} else {
    echo "X";
}
} else if($code == 0) {
    $sql_post =
    "SELECT idx
    FROM Post
    WHERE userIdx = '$idx_master'
    ";

    $query = mysqli_query($conn, $sql_post);

    while($result = mysqli_fetch_assoc($query)) {
        $postIdx = $result['idx'];

        $sql_image = 
        "SELECT path
        FROM Image_post
        WHERE postIdx = '$postIdx'
        ORDER BY idx ASC
        LIMIT 1
        ";

        $query_image = mysqli_query($conn, $sql_image);
        $result_image = mysqli_fetch_assoc($query_image);

        $sql_num =
        "SELECT path
        FROM Image_post
        WHERE postIdx = '$postIdx'
        ";

        $query_num = mysqli_query($conn, $sql_num);

        $num_row = $query_num -> $num_rows;

        array_push($data, array(
            'postIdx' => $postIdx,
            'thumbnail' => $result_image['path'],
            'image_num' => $num_row
        ));

        $json = json_encode($data, JSON_PRETTY_PRINT + JSON_UNESCAPED_UNICODE);
    }

    echo $json;
}

  




?>