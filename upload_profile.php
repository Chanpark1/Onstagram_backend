<?php
error_reporting(E_ALL);
ini_set("display_errors", 1);

include_once 'dbconn.php';

if(isset($_FILES['uploaded_file']['name'])) {

    $idx = $_POST['idx'];

    $basename = basename($_FILES['uploaded_file']['name']);

    $tmp_file = $_FILES['uploaded_file']['tmp_name'];

    move_uploaded_file($tmp_file,"./profileImage/".$basename);

    $sql = 
    "UPDATE User
    SET profileImage = 'http://43.200.84.107/profileImage/".$basename."',
    del_path = '../profileImage/".$basename."'
    WHERE idx = '$idx'
    ";

    $sql_result = mysqli_query($conn, $sql);

    echo $idx;
} else {
    echo "Fail";
}
?>