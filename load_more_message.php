<?php
error_reporting(E_ALL);
ini_set("display_errors", 1);
date_default_timezone_set('Asia/Seoul');

include_once 'dbconn.php';

$m_idx = $_POST['idx'];
$t_idx = $_POST['to_idx'];
$f_idx = $_POST['from_idx'];
$r_idx = $_POST['room_idx'];

$count = (int)$m_idx;

$data = array();

$s_message = 
"SELECT *
FROM MessagePrivate
WHERE room_idx = '$r_idx'
AND idx < '$count'
ORDER BY idx DESC
LIMIT 10
";

$q_message = mysqli_query($conn, $s_message);

while($r = mysqli_fetch_assoc($q_message)) {
    if($r['to_idx'] == $t_idx) {
        $view = 0;
    } else { 
        $view = 1;
    }

    $s_user = 
    "SELECT profileImage
    FROM User
    WHERE idx = '$t_idx'
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
}

echo $json;




?>