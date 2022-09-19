<?php

include('../database/config.php');

$result_array = array();
$result_array['data'] = array();
$result_array['success'] = 1;
$result_array['message'] = "";

$transaction_id = ($conn -> real_escape_string($_POST['transaction_id'])) ? $conn -> real_escape_string($_POST['transaction_id']) : $result_array['success'] = 0;
$report_convo_id = "";

if ($result_array['success'] != 0) {

    // Create a prepared statement
    $stmt1 = $conn -> stmt_init();
    $stmt2 = $conn -> stmt_init();

    if ($stmt1 -> prepare("
    SELECT transaction_id, 
    report_convo_id 
    FROM `assistance_transactions` 
    WHERE transaction_id = ?;")) {
        // Bind parameters
        $stmt1 -> bind_param("s", $transaction_id);

        // Execute query
        $stmt1 -> execute();

        // Fetch values
        $result = $stmt1 -> get_result();
        while($row = $result -> fetch_assoc()){
            $report_convo_id = $row['report_convo_id'];
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
        FROM `report_responses` 
        WHERE report_convo_id = ?
        ORDER BY date_responded ASC")) {
            // Bind parameters
            $stmt2 -> bind_param("s", $report_convo_id);

            // Execute query
            $stmt2 -> execute();

            // Fetch values
            $result = $stmt2 -> get_result();
            $numRows = $result -> num_rows;
            if ($numRows > 0) {
                $index['is_admin'] = "";
                while($row = $result -> fetch_assoc()){

                    $index['sender'] = $row['report_response_sender_name'];
                    $index['body'] = $row['report_response_details'];
                    //$index['sent'] = date("Y-m-d h:iA", strtotime($row['date_responded']));
                    $index['sent'] = $row['date_responded'];
                    
                    if ($row['admin_id'] != 0) {
                        $index['is_admin'] = "1";
                    } else {
                        $index['is_admin'] = "0";
                    }

                    array_push($result_array['data'], $index);
                }
                
            } else {
                $result_array['success'] = 0;
                $result_array['message'] .= "No Messages";
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
    $result_array['message'] .= "Please fill out the blank fields";
}

if ($result_array['success'] != 0) {
    $result_array['success'] = 1;
    $result_array['message'] = "Success";
}

echo json_encode($result_array, JSON_UNESCAPED_UNICODE);

$conn -> close();

?>