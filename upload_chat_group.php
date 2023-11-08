<?php
error_reporting(E_ALL);
ini_set("display_errors", 1);
date_default_timezone_set('Asia/Seoul');


include_once 'dbconn.php';

$date = date("Y-m-d H:i:s");

$msg = $_POST['message'];

// $roomIdx = $_POST['room_idx'];
$sender_idx = $_POST['sender_idx'];
if(isset($_POST['room_idx'])) {

    $room_idx = $_POST['room_idx'];
    $sender_idx = $_POST['sender_idx'];

    $s_insert = 
    "INSERT INTO chat_room_message(sender_idx, content, created, room_idx)
    VALUES('$sender_idx', '$msg', '$date', '$room_idx');
    ";

    if($q_insert = mysqli_query($conn, $s_insert)) {
        echo "commit";
    } else {
        echo "failed";
    }

} else {
    if(isset($_POST['idx_list'])) {
        $array = $_POST['idx_list'];

        $temp_name = implode('.', $array);

        $conn -> begin_transaction();
    
        try {
            $s_i1 = 
            "INSERT INTO ChattingRoom(room_name, room_created)
            VALUES('$temp_name','$date')
            ";

            $q_i1 = mysqli_query($conn, $s_i1);

            $s_s = 
            "SELECT roomIdx 
            FROM ChattingRoom
            WHERE room_name = '$temp_name'
            ";
            
            $q_s = mysqli_query($conn, $s_s);

            $r_s = mysqli_fetch_assoc($q_s);

            $room_idx = $r_s['roomIdx'];

            foreach($array as $val) {
                $s_i2 =
                "INSERT INTO chat_room_members(chat_room_idx, user_idx)
                VALUES('$room_idx', '$val')
                ";

                $q_i2 = mysqli_query($conn, $s_i2);

            }

            $s_message = 
            "INSERT INTO chat_room_message(sender_idx, content, created, room_idx)
            VALUES('$sender_idx', '$msg', '$date', '$room_idx');
            ";

            $q_message = mysqli_query($conn, $s_message);

            $conn -> commit();

            //chat_room_message 쿼리 추가

            echo $room_idx;

        } catch (Exception $e) {
             $conn -> rollback();

             echo "EXCEPTION THROWN";
        }   
    }
      
    
}

?>