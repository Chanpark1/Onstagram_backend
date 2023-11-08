<?php
error_reporting(E_ALL);
ini_set("display_errors", 1);

include_once 'dbconn.php';

////// 전부 수정 필요

$to_idx = $_POST['to_idx'];
$from_idx = $_POST['from_idx'];

$data = array();

$s_check = 
"SELECT chat_room_idx
FROM chat_room_members
WHERE user_idx = '$to_idx'
OR user_idx = '$from_idx'
";

$q_check = mysqli_query($conn, $s_check);

$r_check = mysqli_fetch_assoc($q_check);

$room_idx = $r_check['chat_room_idx'];

$s_get = 
"SELECT *
FROM MessagePrivate
WHERE room_idx = '$room_idx'
ORDER BY idx DESC
LIMIT 10
";

$q_get = mysqli_query($conn, $s_get);

while($r = mysqli_fetch_assoc($q_get)) {

    if($r['to_idx'] == $to_idx) {
        $view = 0;
    } else {
        $view = 1;
    }

    $s_user = 
    "SELECT profileImage
    FROM User
    WHERE idx = '$to_idx'
    ";

    $q_user = mysqli_query($conn, $s_user);

    $r_user = mysqli_fetch_assoc($q_user);

    array_push($data, array(
        'idx' => $r['idx'],
        'from_idx' => $r['from_idx'],
        'to_idx' => $r['to_idx'],
        'content' => $r['content'],
        'userImage' => $r_user['profileImage'],
        'ViewType' => $view,
        'image' => null,
        'room_idx' => $r['room_idx']
    ));

    $json = json_encode($data, JSON_PRETTY_PRINT + JSON_UNESCAPED_UNICODE);
};

echo $json;









?>