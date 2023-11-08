<?php
error_reporting(E_ALL);
ini_set("display_errors", 1);

include_once 'dbconn.php';

$idx_list = $_POST['idx_list'];
$room_idx = $_POST['room_idx'];
$sender_idx = $_POST['sender_idx'];

$data = array();

foreach($idx_list as $val) {
    $s_msg = 
    "SELECT idx, sender_idx, content
    FROM chat_room_message
    WHERE room_idx = '$room_idx'
    ORDER BY idx DESC
    LIMIT 10
    ";

    $q_msg = mysqli_query($conn, $s_msg);

    while($r_msg = mysqli_fetch_assoc($q_msg)) {

        if($r_msg['sender_idx'] == $sender_idx) {
            $view = 0;
        } else {
            $view = 1;
        }

        // $s_user = 
        // "SELECT user_idx
        // FROM chat_room_members
        // WHERE room_idx = '$room_idx'
        // ";

        // $q_user = mysqli_query($conn, $s_user);

        // while($r_user = mysqli_fetch_assoc($q_user)) {
        //     $user_idx = $r_user['user_idx'];

        //     $s_info =
        //     "SELECT profileImage, username, name
        //     FROM User
        //     WHERE idx = '$user_idx'
        //     ";

        // };
        
        $s_user = 
        "SELECT U.profileImage, U.username, U.name
        FROM User AS U
        JOIN chat_room_members AS CRM ON CRM.user_idx = U.idx
        WHERE CRM.room_idx = '$room_idx'
        ";

        $q_user = mysqli_query($s_user);

        while($r_user = mysqli_fetch_assoc($conn, $q_user)) {
            array_push($data, array(
                'idx' => $r_msg['idx'],
                'content' => $r_msg['content'],
                'profileImage' => $r_user['profileImage'],
                'username' => $r_user['username'],
                'name' => $r_user['name'],
                'ViewType' => $view
            ));

            $json = json_encode($data, JSON_PRETTY_PRINT + JSON_UNESCAPED_UNICODE);
        }
    }

}

echo $json;




?>