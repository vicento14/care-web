<?php

//Resolve

include('../database/config.php');
require_once './notif_insert.php';

session_start();

$admin_id = $_SESSION['admin_id'];

$transaction_id = ($conn -> real_escape_string($_POST['transaction_id'])) ? $conn -> real_escape_string($_POST['transaction_id']) : '';

$response_msg = "";

// Create a prepared statement
$stmt1 = $conn -> stmt_init();
$stmt2 = $conn -> stmt_init();

if ($stmt1 -> prepare("
SELECT admin_id 
FROM `assistance_transactions` 
WHERE transaction_id = ?;")) {
    // Bind parameters
    $stmt1 -> bind_param("s", $transaction_id);

    // Execute query
    $stmt1 -> execute();

    // Fetch values
    $result = $stmt1 -> get_result();
    while($row = $result -> fetch_assoc()){
        if ($admin_id != $row['admin_id']) {
            $response_msg = "failed";
        }
    }

    // Close statement
    $stmt1 -> close();

    $response_msg = "success";

} else {
    echo "Query Error (report_complaints_resolve.php stmt1->prepare) : $stmt1->errno : $stmt1->error";
    $response_msg = "failed";
}

if ($response_msg != "failed") {
    if ($stmt2 -> prepare("
    UPDATE `assistance_transactions`
    SET is_resolved = 1
    WHERE transaction_id = ?;")) {
        // Bind parameters
        $stmt2 -> bind_param("s", $transaction_id);

        // Execute query
        $stmt2 -> execute();

        // Close statement
        $stmt2 -> close();

        $response_msg = "success";

    } else {
        echo "Query Error (report_complaints_resolve.php stmt2->prepare) : $stmt2->errno : $stmt2->error";
        $response_msg = "failed";
    }
}

if ($response_msg != "failed") {
    notif_insert(4, $transaction_id);
}

echo $response_msg;

$conn -> close();

?>