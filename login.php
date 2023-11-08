<?php
error_reporting(E_ALL);
ini_set("display_errors", 1);

include_once 'dbconn.php';

$account = $_POST['account'];
$pw = $_POST['password'];

function is_email($account) {
    return filter_var($account, FILTER_VALIDATE_EMAIL) !== false;
}

function is_phone($account) {

    return preg_match('/^(010|011|016|017|018|019)[0-9]{7,8}$/', $account) === 1;
}

function is_nickname($account) {
    return preg_match('/^[a-zA-Z0-9_]+$/', $account) === 1;
}



if(is_email($account)) {
    $sql_email = 
    "SELECT idx
    FROM User
    WHERE email = '$account'
    AND
    password = '$pw'
    ";

    $result_email = mysqli_query($conn, $sql_email);
    $row_email = mysqli_fetch_assoc($result_email);
    if(mysqli_num_rows($result_email) == 1) {
        echo $row_email['idx'];
    } else {
        echo "X!";
    }

} else 
if(is_phone($account)) {
    $sql_email = 
    "SELECT idx
    FROM User
    WHERE phone = '$account'
    AND
    password = '$pw'
    ";

    $result_email = mysqli_query($conn, $sql_email);
    $row_email = mysqli_fetch_assoc($result_email);
    if(mysqli_num_rows($result_email) == 1) {
        echo $row_email['idx'];
    } else {
        echo "X!!";
    }

} else if(is_nickname($account)) {
    $sql_email = 
    "SELECT idx
    FROM User
    WHERE username = '$account'
    AND
    password = '$pw'
    ";

    $result_email = mysqli_query($conn, $sql_email);
    $row_email = mysqli_fetch_assoc($result_email);
    if(mysqli_num_rows($result_email) == 1) {
        echo $row_email['idx'];
    } else {
        echo "X!!!";
    }
} else {
    echo $account;
}

?>
