<?php
error_reporting(E_ALL);
ini_set("display_errors", 1);

include_once 'dbconn.php';

$idx = $_POST['idx'];

$file_path = "./profileImage";

if(isset($_FILES['uploaded_file']['name'])) {

    // 기존 프로필 이미지 경로를 가져와 unlink 해준다.
    $sql_origin = 
    "SELECT del_path
    FROM User
    WHERE idx = '$idx'
    ";

    $result_origin = mysqli_query($conn, $sql_origin);

    $origin = mysqli_fetch_assoc($result_origin);

    $origin_row = $origin['del_path'];

    if(isset($origin_row)) {
        unlink($origin_row);
    }
    // basename == 파일 경로에서 파일명만 추출하는 함수. 파일의 이름 부분만 리턴한다.
    $basename = basename($_FILES['uploaded_file']['name']);
    $file_path = $file_path.$basename;

    if(move_uploaded_file($_FILES['uploaded_file']['tmp_name'], "./profileImage/".$basename)) {
        $update_query = 
        "UPDATE User
        SET profileImage = 'http://43.200.84.107/profileImage/".$basename."',
        del_path = '/var/www/html/profileImage/".$basename."'
        WHERE idx = '$idx'
        ";

        $update_result = mysqli_query($conn, $update_query);

    }
} else {
    $sql_del = 
    "SELECT del_path
    FROM User
    WHERE idx = '$idx'
    ";

    $result_origin = mysqli_query($conn, $sql_del);

    $origin = mysqli_fetch_assoc($result_origin);
    $origin_row = $origin['del_path'];

    if(isset($origin_row)) {
        unlink($origin_row);
    }

    $update_query = 
    "UPDATE User
    SET profileImage = null,
    del_path = null
    WHERE idx = '$idx'
    ";

    $query = mysqli_query($conn, $update_query);

    
}






?>