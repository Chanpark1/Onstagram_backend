<?php
error_reporting(E_ALL);
ini_set("display_errors", 1);

include_once 'dbconn.php';

$array = $_POST['idx_list'];

$data = array();

foreach($array as $val) {
    $s = 
    "SELECT username, name, profileImage
    FROM User
    WHERE idx = '$val'
    ";

    $q = mysqli_query($conn, $s);

    while($r = mysqli_fetch_assoc($q)) {

        array_push($data, array(
            'username' => $r['username'],
            'name' => $r['name'],
            'profileImage' => $r['profileImage']
        ));

        $json = json_encode($data, JSON_PRETTY_PRINT + JSON_UNESCAPED_UNICODE);
    }


}

echo $json;
?>