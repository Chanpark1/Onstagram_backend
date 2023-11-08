<?php
error_reporting(E_ALL);
ini_set("display_errors", 1);

include_once 'dbconn.php';

$idx = $_POST['idx'];

$data = array();

$s_user = 
"SELECT idx, username, name, profileImage
FROM User
WHERE idx <> $idx
";

$q_user = mysqli_query($conn, $s_user);

while($r = mysqli_fetch_assoc($q_user)) {

    array_push($data, array(
        'idx' => $r['idx'],
        'username' => $r['username'],
        'name' => $r['name'],
        'profileImage'=> $r['profileImage']
    ));

    $json = json_encode($data, JSON_PRETTY_PRINT + JSON_UNESCAPED_UNICODE);

}

echo $json;





?>