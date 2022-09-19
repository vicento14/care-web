<?php

//Resolve

include('../database/config.php');
require_once './notif_insert.php';

session_start();

$admin_id = $_SESSION['admin_id'];

$transaction_id = ($conn -> real_escape_string($_POST['transaction_id'])) ? $conn -> real_escape_string($_POST['transaction_id']) : '';
$dept_id = ($conn -> real_escape_string($_POST['dept_id'])) ? $conn -> real_escape_string($_POST['dept_id']) : '';

$response_msg = "";
$success = 1;

// Create a prepared statement
$stmt1 = $conn -> stmt_init();
$stmt2 = $conn -> stmt_init();

if ($stmt1 -> prepare("
SELECT dept_id 
FROM `assistance_transactions` 
WHERE transaction_id = ?;")) {
    // Bind parameters
    $stmt1 -> bind_param("s", $transaction_id);

    // Execute query
    $stmt1 -> execute();

    // Fetch values
    $result = $stmt1 -> get_result();
    while($row = $result -> fetch_assoc()){
        if ($dept_id == $row['dept_id']) {
            $response_msg = "You choose your current department. Please try again later";
            $success = 0;
        }
    }

    // Close statement
    $stmt1 -> close();

} else {
    $response_msg = "Query Error (report_resolve.php stmt1->prepare) : $stmt1->errno : $stmt1->error";
    $success = 0;
}

if ($success != 0) {
    if ($stmt2 -> prepare("
    UPDATE `assistance_transactions`
    SET dept_id = ?
    WHERE transaction_id = ?;")) {
        // Bind parameters
        $stmt2 -> bind_param("ss", $dept_id, $transaction_id);

        // Execute query
        $stmt2 -> execute();

        // Close statement
        $stmt2 -> close();

        $response_msg = "success";

    } else {
        $response_msg = "Query Error (report_resolve.php stmt2->prepare) : $stmt2->errno : $stmt2->error";
        $success = 0;
    }
}

if ($success != 0) {
    //notif_insert(5, $transaction_id, $admin_id);
}

echo $response_msg;

$conn -> close();

?>