<?php

include('../database/config.php');

$result_array = array();
$result_array['success'] = 1;
$result_array['message'] = "";
$result_array['data'] = array();

$transaction_id = ($conn -> real_escape_string($_POST['transaction_id'])) ? $conn -> real_escape_string($_POST['transaction_id']) : $result_array['success'] = 0;
$is_resolved = 0;
$is_rated = 0;

if ($result_array['success'] != 0) {

    // Create a prepared statement
    $stmt1 = $conn -> stmt_init();
    $stmt2 = $conn -> stmt_init();

    if ($stmt1 -> prepare(
        "SELECT is_resolved FROM `assistance_transactions` WHERE transaction_id = ?")) {

        // Bind parameters
        $stmt1 -> bind_param("s", $transaction_id);

        // Execute query
        $stmt1 -> execute();

        // Fetch values
        $result = $stmt1 -> get_result();
        while($row = $result -> fetch_assoc()){
            $is_resolved = $row['is_resolved'];
        }

        // Close statement
        $stmt1 -> close();

    } else {
        $result_array['success'] = 0;
        $result_array['message'] .= "Query Error (report_rating_check.php stmt1->prepare) : $stmt1->errno : $stmt1->error";
    }

    if ($stmt2 -> prepare(
        "SELECT transaction_id FROM `report_ratings` WHERE transaction_id = ?")) {

        // Bind parameters
        $stmt2 -> bind_param("s", $transaction_id);

        // Execute query
        $stmt2 -> execute();

        // Fetch values
        $result = $stmt2 -> get_result();
        $numRows = $result -> num_rows;
        if ($numRows > 0) {
            $is_rated = 1;
        } else {
            $is_rated = 0;
        }

        // Close statement
        $stmt2 -> close();

    } else {
        $result_array['success'] = 0;
        $result_array['message'] .= "Query Error (report_rating_check.php stmt2->prepare) : $stmt2->errno : $stmt2->error";
    }

    $index['is_resolved'] = $is_resolved;
    $index['is_rated'] = $is_rated;
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