<?php

//Lock / Unlock

include('../database/config.php');
require_once './notif_insert.php';

session_start();

$admin_id = $_SESSION['admin_id'];

$transaction_id = ($conn -> real_escape_string($_POST['transaction_id'])) ? $conn -> real_escape_string($_POST['transaction_id']) : '';
$is_lock = ($conn -> real_escape_string($_POST['is_lock'])) ? $conn -> real_escape_string($_POST['is_lock']) : 0;

$response_array = array();
$response_msg = "";

// Create a prepared statement
$stmt1 = $conn -> stmt_init();
$stmt2 = $conn -> stmt_init();

if ($is_lock == 1) {
    if ($stmt1 -> prepare("
    UPDATE `assistance_transactions`
    SET admin_id = ?  
    WHERE transaction_id = ?;")) {
        // Bind parameters
        $stmt1 -> bind_param("ss", $admin_id, $transaction_id);

        // Execute query
        $stmt1 -> execute();

        // Close statement
        $stmt1 -> close();

        $response_msg = "success";

    } else {
        echo "Query Error (report_complaints_lock_unlock.php stmt1->prepare) : $stmt1->errno : $stmt1->error";
        $response_msg = "failed";
    }
    if ($response_msg != "failed") {
        notif_insert(2, $transaction_id);
    }
} else {
    if ($stmt2 -> prepare("
    UPDATE `assistance_transactions`
    SET admin_id = 0  
    WHERE transaction_id = ?;")) {
        // Bind parameters
        $stmt2 -> bind_param("s", $transaction_id);

        // Execute query
        $stmt2 -> execute();

        // Close statement
        $stmt2 -> close();

        $response_msg = "success";

    } else {
        echo "Query Error (report_complaints_lock_unlock.php stmt2->prepare) : $stmt2->errno : $stmt2->error";
        $response_msg = "failed";
    }
    if ($response_msg != "failed") {
        notif_insert(3, $transaction_id);
    }
}

$response_array = array(
    'response_msg' => $response_msg, 
    'is_lock' => $is_lock);

echo json_encode($response_array, JSON_FORCE_OBJECT);

$conn -> close();

?>