<?php

include('../database/config.php');

$result_array = array();
$result_array['success'] = 1;
$result_array['message'] = "";
$result_array['data'] = array();

$user_id = ($conn -> real_escape_string($_POST['user_id'])) ? $conn -> real_escape_string($_POST['user_id']) : $result_array['success'] = 0;
$total_pending = 0;
$total_resolved = 0;

if ($result_array['success'] != 0) {

    // Create a prepared statement
    $stmt1 = $conn -> stmt_init();
    $stmt2 = $conn -> stmt_init();

    if ($stmt1 -> prepare("
    SELECT COUNT(transaction_id)
    FROM `assistance_transactions`
    WHERE is_resolved = 0 
    AND user_id = ?;")) {
        // Bind parameters
        $stmt1 -> bind_param("s", $user_id);

        // Execute query
        $stmt1 -> execute();

        // Fetch values
        $result = $stmt1 -> get_result();
        $numRows = $result -> num_rows;
        if ($numRows > 0) {
            while($row = $result -> fetch_assoc()){
                $total_pending = $row['COUNT(transaction_id)'];
            }
        }

        // Close statement
        $stmt1 -> close();

    } else {
        $result_array['success'] = 0;
        $result_array['message'] .= "Query Error (dashboard_details_user.php stmt1->prepare) : $stmt1->errno : $stmt1->error";
    }

    if ($stmt2 -> prepare("
    SELECT COUNT(transaction_id)
    FROM `assistance_transactions`
    WHERE is_resolved = 1 
    AND user_id = ?;")) {
        // Bind parameters
        $stmt2 -> bind_param("s", $user_id);

        // Execute query
        $stmt2 -> execute();

        // Fetch values
        $result = $stmt2 -> get_result();
        $numRows = $result -> num_rows;
        if ($numRows > 0) {
            while($row = $result -> fetch_assoc()){
                $total_resolved = $row['COUNT(transaction_id)'];
            }
        }

        // Close statement
        $stmt2 -> close();

    } else {
        $result_array['success'] = 0;
        $result_array['message'] .= "Query Error (dashboard_details_user.php stmt2->prepare) : $stmt2->errno : $stmt2->error";
    }

    $index['total_pending'] = $total_pending;
    $index['total_resolved'] = $total_resolved;
    array_push($result_array['data'], $index);

} else {
    $result_array['message'] .= "Please fill out the blank fields ";
}

if ($result_array['success'] != 0) {
    $result_array['success'] = 1;
    $result_array['message'] = "Success";
}

echo json_encode($result_array);

$conn -> close();

?>