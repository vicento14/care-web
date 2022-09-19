<?php

//View

include('../database/config.php');

$transaction_id = ($conn -> real_escape_string($_POST['transaction_id'])) ? $conn -> real_escape_string($_POST['transaction_id']) : '';
$report_convo_id = "";
$response_msg = "";
$is_anonymous = 0;
$report_response_sender_name = "";

$data = "";

// Create a prepared statement
$stmt1 = $conn -> stmt_init();
$stmt2 = $conn -> stmt_init();

if ($stmt1 -> prepare("
SELECT transaction_id, 
report_convo_id, is_anonymous  
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
        $is_anonymous = intval($row['is_anonymous']);
    }

    // Close statement
    $stmt1 -> close();

    $response_msg = "success";

} else {
    echo "Query Error (report_response_view.php stmt1->prepare) : $stmt1->errno : $stmt1->error";
    $response_msg = "failed";
}

function get_starred($str) {
    $len = strlen($str);
    return substr($str, 0, 1).str_repeat('*', $len - 2);
}

if ($response_msg != "failed") {
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
            while($row = $result -> fetch_assoc()){
                $date_responded = date("Y-m-d h:iA", strtotime($row['date_responded']));
                if ($row['user_id'] != 0) {
                    if ($is_anonymous == 1) {
                        $report_response_sender_name = get_starred($row['report_response_sender_name']);
                    }
                    $data .= "<div class='incoming_msg'>
                    <div class='incoming_msg_img'>
                    <img src='../assets/img/CARELogo.png' alt='sunil'>
                    </div>
                    <div class='received_msg'>
                    <div class='received_withd_msg'>
                    <h6 class='text-success m-2'>{$report_response_sender_name}</h6>
                    <p>{$row['report_response_details']}</p>
                    <span class='time_date'>{$date_responded}</span>
                    </div>
                    </div>
                    </div>";
                } else {
                    $data .= "<div class='outgoing_msg'>
                    <div class='sent_msg'>
                    <p>{$row['report_response_details']}</p>
                    <span class='time_date'>{$date_responded}</span>
                    </div>
                    </div>";
                }
            }
        }

        // Close statement
        $stmt2 -> close();

        $response_msg = "success";

        echo $data;

    } else {
        echo "Query Error (report_response_view.php stmt2->prepare) : $stmt2->errno : $stmt2->error";
        $response_msg = "failed";
    }
} else {
    echo "transaction_id not found. ";
}

$conn -> close();

?>