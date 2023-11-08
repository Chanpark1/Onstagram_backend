<?php
error_reporting(E_ALL);
ini_set("display_errors", 1);

date_default_timezone_set('Asia/Seoul');

include_once 'dbconn.php';

$idx = $_POST['idx'];
$content = $_POST['content'];
$count = $_POST['count'];
$count_int = (int)$count;


$data = date("Y-m-d H:i:s");
$file_path = "./postImage";
$fn = date("ymdHis");

$sql_post = 
"INSERT INTO Post(content, userIdx, created)
VALUES('$content', '$idx', '$fn')
";

$result_post = mysqli_query($conn, $sql_post);

$sql_idx = 
"SELECT idx
FROM Post
WHERE userIdx = '$idx'
AND created = '$fn'
";

$result_idx = mysqli_query($conn, $sql_idx);


$row_idx = mysqli_fetch_assoc($result_idx);

$post_idx = $row_idx['idx'];

if(isset($_FILES['uploaded_file0']['name'])) {
    for($i = 0; $i < $count_int; $i++) {
        $basename = basename($_FILES['uploaded_file'.$i]['name']);
        $file_path = $file_path . $basename;

        if(isset($_FILES['uploaded_file'.$i])) {
            move_uploaded_file($_FILES['uploaded_file'.$i]['tmp_name'], "./postImage/".$fn.$basename);
            $query_image = 
            "INSERT INTO Image_post(path, postIdx, del_path)
            VALUES ('http://43.200.84.107/postImage/".$fn.$basename."', '$post_idx','../postImage/".$fn.$basename."' )
            ";

            if($result_query = mysqli_query($conn, $query_image)) {
                echo "O";
            } else {
                echo "X";
            }
        }

    }
}



?>