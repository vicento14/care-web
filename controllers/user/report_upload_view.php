<?php
include('../database/config.php');

$result_array = array();
$result_array['success'] = 1;
$result_array['message'] = "";
$result_array['data'] = array();

$transaction_id = ($conn -> real_escape_string($_POST['transaction_id'])) ? $conn -> real_escape_string($_POST['transaction_id']) : $result_array['success'] = 0;
$user_id = 0;
$upload_set_id = 0;

if ($result_array['success'] != 0) {

    // Create a prepared statement
    $stmt1 = $conn -> stmt_init();
    $stmt2 = $conn -> stmt_init();

    if ($stmt1 -> prepare("
    SELECT transaction_id, 
    user_id, upload_set_id 
    FROM `assistance_transactions` 
    WHERE transaction_id = ?")) {
        // Bind parameters
        $stmt1 -> bind_param("s", $transaction_id);

        // Execute query
        $stmt1 -> execute();

        // Fetch values
        $result = $stmt1 -> get_result();
        while($row = $result -> fetch_assoc()){
            $user_id = $row['user_id'];
            $upload_set_id = $row['upload_set_id'];
        }

        // Close statement
        $stmt1 -> close();

    } else {
        $result_array['success'] = 0;
        $result_array['message'] .= "Query Error (report_response_view.php stmt1->prepare) : $stmt1->errno : $stmt1->error";
    }

    if ($result_array['success'] != 0) {
        if ($stmt2 -> prepare("
        SELECT * 
        FROM `uploads` 
        WHERE upload_set_id = ?;")) {
            // Bind parameters
            $stmt2 -> bind_param("s", $upload_set_id);

            // Execute query
            $stmt2 -> execute();

            // Fetch values
            $result = $stmt2 -> get_result();
            $numRows = $result -> num_rows;
            if ($numRows > 0) {
                while($row = $result -> fetch_assoc()){
                    $index['upload_filename'] = $row['upload_filename'];
                    $index['upload_url'] = $row['upload_url'];
                    array_push($result_array['data'], $index);
                }
            } else {
                $result_array['success'] = 0;
                $result_array['message'] .= "No files uploaded";
            }

            // Close statement
            $stmt2 -> close();

        } else {
            $result_array['success'] = 0;
            $result_array['message'] .= "Query Error (report_response_view.php stmt2->prepare) : $stmt2->errno : $stmt2->error";
        }
    } else {
        $result_array['success'] = 0;
        $result_array['message'] .= "transaction_id not found. ";
    }

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