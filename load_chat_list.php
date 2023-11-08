<?php
error_reporting(E_ALL);
ini_set("display_errors", 1);

include_once 'dbconn.php';

$idx = $_POST['idx'];

// 내가 속한 채팅방의 idx 모두 가져오기
$s_room = 
"SELECT chat_room_idx
FROM chat_room_members
WHERE user_idx = '$idx'
";

$q_room = mysqli_query($conn, $s_room);

$data = array();
$user = array();
$idx_list = array();

while($r_room = mysqli_fetch_assoc($q_room)) {
    $roomIdx = $r_room['chat_room_idx'];

    // 채팅방 멤버 수
    $s_count = 
    "SELECT user_idx
    FROM chat_room_members
    WHERE chat_room_idx = '$roomIdx'
    ";

    $q_count = $conn -> query($s_count);

    $r_count = $q_count -> num_rows;
    // ------------------------------- \\

    // 개인 채팅 - 상대 pk 값 
    $s_opp = 
    "SELECT user_idx
    FROM chat_room_members
    WHERE chat_room_idx = '$roomIdx'
    AND user_idx <> '$idx'
    ";
    
    $q_opp = mysqli_query($conn, $s_opp);
    // ------------------------------ \\
    while($r_opp = mysqli_fetch_assoc($q_opp)) {
        $u_idx = $r_opp['user_idx'];

        $s_user = 
        "SELECT idx, username, name, profileImage 
        FROM User
        WHERE idx = '$u_idx'
        ";

        $q_user = mysqli_query($conn, $s_user);

        while($r_user = mysqli_fetch_assoc($q_user)) {
            array_push($user, array(
                'idx' => $r_user['idx'],
                'username' => $r_user['username'],
                'profileImage' => $r_user['profileImage']
            ));

            array_push($idx_list, array(
                'idx' => $u_idx
            ));
        }

        $s_msg = 
         "SELECT content
        FROM chat_room_message
        WHERE room_idx = '$roomIdx'
        AND sender_idx = '$idx'
        ORDER BY idx DESC
        LIMIT 1
        ";

        $q_msg = mysqli_query($conn, $s_msg);

        while($r_msg = mysqli_fetch_assoc($q_msg)) {
            $msg = $r_msg['content'];

            array_push($data, array(
                'room_idx' => $roomIdx,
                'user_info' => $user,
                'message' => $msg,
                'count_members' => $r_count,
                'idx_list' => $idx_list
            ));
        }
        $json = json_encode($data, JSON_PRETTY_PRINT + JSON_UNESCAPED_UNICODE);

        $user = array();
        $idx_list = array();

    }
}

echo $json;





?>