<?php
error_reporting(E_ALL);
ini_set("display_errors", 1);

include_once 'dbconn.php';


$data = $_POST['data'];

$sql =
"SELECT idx 
FROM User
WHERE username LIKE '%$data%'
OR name LIKE '%$data%'
";

$result = mysqli_query($conn, $sql);

$data = array();

while($row = mysqli_fetch_assoc($result)) {
    $idx = $row['idx'];

    $sql_search = 
    "SELECT idx, username, name, profileImage
    FROM User
    WHERE idx = '$idx'
    ";

    $result_search = mysqli_query($conn, $sql_search);

    $rows = mysqli_fetch_assoc($result_search);

    array_push($data, array(
        'idx' => $rows['idx'],
        'username' => $rows['username'],
        'name' => $rows['name'],
        'profileImage' => $rows['profileImage']
    ));

    $json = json_encode($data, JSON_PRETTY_PRINT + JSON_UNESCAPED_UNICODE);
}

echo $json;



?>