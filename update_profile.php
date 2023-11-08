<?php
error_reporting(E_ALL);
ini_set("display_errors", 1);

include_once 'dbconn.php';

$idx = $_POST['idx'];

$value = $_POST['value'];

$type = $_POST['type'];

// 쿠키 생성
$expiration = time() + (7 * 24 * 60 * 60);
$cookieName = $type.$idx;
// 쿠키 이름
$cookieValue = $value.$idx;
// 변경된 value
// $newValue = $value.$idx;
// setcookie($cookieName, $newValue, $expiration);
// 쿠키 세팅

if(isset($_COOKIE[$cookieName])) {
    // 쿠키가 존재한다면
    $currentValue = $_COOKIE[$cookieName];

    $updatedValue = $type.$idx;
    // POST로 받은 타입과 pk값
    echo "X";
} else {

    $newValue = $value.$idx;

    setcookie($cookieName, $newValue, $expiration);
    // 쿠키 세팅하고

    if($type == "name") {
        $sql = 
        "UPDATE User
        SET name = '$value'
        WHERE idx = '$idx'
        ";
   
        $query = mysqli_query($conn, $sql);
        echo $cookieName;
    
    } else if($type == "username") {
        $sql = 
        "UPDATE User
        SET username = '$value'
        WHERE idx = '$idx'
        ";
    
        $query = mysqli_query($conn, $sql);
    
        echo $cookieName;
    
    } else if($type == "intro") {
        $sql = 
        "UPDATE User
        SET content = '$value'
        WHERE idx = '$idx'
        ";
        $query = mysqli_query($conn, $sql); 
        echo $cookieName;
    }


}




?>