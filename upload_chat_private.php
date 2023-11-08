<?php
error_reporting(E_ALL);
ini_set("display_errors", 1);
date_default_timezone_set('Asia/Seoul');

include_once 'dbconn.php';

$msg = $_POST['message'];
$sender_idx = $_POST['from_idx'];
$to_idx = $_POST['to_idx'];

$date = date("Y-m-d H:i:s");

$temp_name = $from_idx.$to_idx;

$sql_check = 
"SELECT chat_room_idx 
FROM chat_room_members
WHERE user_idx = '$to_idx'
OR user_idx = '$from_idx'
";

$query_check = mysqli_query($conn, $sql_check);
$check = mysqli_fetch_assoc($query_check);
if(!isset($check['chat_room_idx'])) {

    $sql_insert = 
    "INSERT INTO ChattingRoom(room_name, room_created)
    VALUES('$temp_name','$date')
    ";

    $query_insert = mysqli_query($conn, $sql_insert);

    if($query_insert) {
        $getIdx = 
        "SELECT roomIdx
        FROM ChattingRoom
        WHERE room_name = '$temp_name'
        ";

        $q = mysqli_query($conn, $getIdx);
        $r = mysqli_fetch_assoc($q);
        if(isset($r['roomIdx'])) {
            $roomIdx = $r['roomIdx'];
            $i1 = 
            "INSERT INTO chat_room_members(chat_room_idx, user_idx)
            VALUES('$roomIdx', '$from_idx')
            ";

            $i1_q = mysqli_query($conn, $i1);

            $i2 = 
            "INSERT INTO chat_room_members(chat_room_idx, user_idx)
            VALUES('$roomIdx', '$to_idx')
            ";

            $i2_q = mysqli_query($conn, $i2);

            if($i1_q && $i2_q) {
                $c = 
                "INSERT INTO chat_room_message(sender_idx, content, created, room_idx)
                VALUES('$from_idx','$msg', '$date','$roomIdx')
                ";

                $c_q = mysqli_query($conn, $c);

            }


            echo "SUCCESS";


        
        }

    }

} else {
    $r_idx = $check['chat_room_idx'];

    $c = 
    "INSERT INTO chat_room_message(sender_idx, content, created, room_idx)
    VALUES('$from_idx', '$msg', '$date','$r_idx')
    ";

    $c_q = mysqli_query($conn, $c);

    echo "SUCCESS!!!";

}



// $sql_check1 = 
// "SELECT idx 
// FROM ChattingPrivate
// WHERE fromIdx = '$from_idx'
// AND toIdx = '$to_idx'
// ";

// $query_check1 = mysqli_query($conn, $sql_check1);

// $check1 = mysqli_fetch_assoc($query_check1);

// $sql_check2 = 
// "SELECT idx
// FROM ChattingPrivate
// WHERE fromIdx = '$to_idx'
// AND toIdx = '$from_idx'
// ";

// $query_check2 = mysqli_query($conn, $sql_check2);

// $check2 = mysqli_fetch_assoc($query_check2);


// if(!isset($check1['idx']) && !isset($check2['idx'])) {
//     $sql_insert = 
//     "INSERT INTO ChattingPrivate(fromIdx, toIdx, created)
//     VALUES('$from_idx','$to_idx', '$date')
//     ";

//     $query_insert = mysqli_query($conn, $sql_insert);

//     $sql_insert2 = 
//     "INSERT INTO ChattingPrivate(fromIdx, toIdx, created)
//     VALUES('$to_idx','$from_idx', '$date')
//     ";

//     $query_insert2 = mysqli_query($conn, $sql_insert2);

//     if($query_insert) {
//         $sql_message = 
//         "INSERT INTO MessagePrivate(from_idx, to_idx, content, created)
//         VALUES ('$from_idx', '$to_idx', '$msg', '$date')
//         ";

//         $query_message = mysqli_query($conn, $sql_message);
        
//         echo "MessageUploaded";
//     }

// } else {
//     $sql_message = 
//         "INSERT INTO MessagePrivate(from_idx, to_idx, content, created)
//         VALUES ('$from_idx', '$to_idx', '$msg', '$date')
//         ";

//         $query_message = mysqli_query($conn, $sql_message);
        
//         echo "MessageUploaded";
// }

?>