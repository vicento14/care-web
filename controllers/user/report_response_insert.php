<?php

include('../database/config.php');
require_once './notif_insert.php';
include('../../vendor/autoload.php');

$result_array = array();
$result_array['success'] = 1;
$result_array['message'] = "";

$report_response_sender_name = $_POST['account_name'];

$transaction_id = ($conn -> real_escape_string($_POST['transaction_id'])) ? $conn -> real_escape_string($_POST['transaction_id']) : $result_array['success'] = 0;
$report_response_id = 0;
$report_response_details = ($_POST['report_response_details']) ? $_POST['report_response_details'] : $result_array['success'] = 0;
$admin_id = 0;
$push_admin_id = 0;
$user_id = ($conn -> real_escape_string($_POST['user_id'])) ? $conn -> real_escape_string($_POST['user_id']) : $result_array['success'] = 0;
$report_convo_id = "";
$is_anonymous = 0;

date_default_timezone_set("Asia/Manila");
$date_responded = date('Y-m-d H:i:s');

if ($result_array['success'] != 0) {

    // Create a prepared statement
    $stmt1 = $conn -> stmt_init();
    $stmt2 = $conn -> stmt_init();
    $stmt3 = $conn -> stmt_init();

    if ($stmt1 -> prepare("
    SELECT report_response_id FROM `report_responses` ORDER BY report_response_id DESC LIMIT 1;")) {
        // Execute query
        $stmt1 -> execute();

        // Fetch values
        $result = $stmt1 -> get_result();
        $numRows = $result -> num_rows;
        if ($numRows > 0) {
            while($row = $result -> fetch_assoc()){
                $report_response_id = intval($row['report_response_id']);
            }
        }

        // Close statement
        $stmt1 -> close();

        $report_response_id++;

    } else {
        $result_array['success'] = 0;
        $result_array['message'] .= "Query Error (report_response_insert.php stmt1->prepare) : $stmt1->errno : $stmt1->error";
    }

    if ($stmt2 -> prepare("
    SELECT transaction_id, user_id, 
    report_convo_id, admin_id, is_resolved, is_anonymous  
    FROM `assistance_transactions` 
    WHERE transaction_id = ?;")) {
        // Bind parameters
        $stmt2 -> bind_param("s", $transaction_id);

        // Execute query
        $stmt2 -> execute();

        // Fetch values
        $result = $stmt2 -> get_result();
        while($row = $result -> fetch_assoc()){
            if ($row['admin_id'] == 0) {
                $result_array['success'] = 0;
                $result_array['message'] .= "Message not sent. The LGU Office Staff doesn't accept your report yet ";
            } else if ($row['is_resolved'] == 1) {
                $result_array['success'] = 0;
                $result_array['message'] .= "Message not sent. The LGU Office Staff have marked your report as resolved. You are not able to send message to a report that was resolved ";
            } else {
                $report_convo_id = $row['report_convo_id'];
                $user_id = $row['user_id'];
                $push_admin_id = $row['admin_id'];
                $is_anonymous = intval($row['is_anonymous']);
            }
        }

        // Close statement
        $stmt2 -> close();

        $response_msg = "success";

    } else {
        $result_array['success'] = 0;
        $result_array['message'] .= "Query Error (report_response_insert.php stmt2->prepare) : $stmt2->errno : $stmt2->error";
    }

    if ($result_array['success'] != 0) {
        if ($stmt3 -> prepare("
        INSERT INTO `report_responses` 
        (report_response_id, report_convo_id, user_id, admin_id,
        report_response_sender_name, report_response_details, date_responded) 
        VALUES (?, ?, ?, ?, ?, ?, ?);")) {
            // Bind parameters
            $stmt3 -> bind_param("sssssss", $report_response_id, $report_convo_id, $user_id, $admin_id, $report_response_sender_name, $report_response_details, $date_responded);

            // Execute query
            $stmt3 -> execute();

            // Close statement
            $stmt3 -> close();

        } else {
            $result_array['success'] = 0;
            $result_array['message'] .= "Query Error (report_response_insert.php stmt3->prepare) : $stmt3->errno : $stmt3->error";
        }
    }

} else {
    $result_array['message'] .= "Please fill out the blank fields";
}

if ($result_array['success'] != 0) {
    $result_array['success'] = notif_insert(1, $transaction_id);
}

if ($result_array['success'] != 0) {
    $result_array['success'] = 1;
    $result_array['message'] = "Success";
}

function get_starred($str) {
    $len = strlen($str);
    return substr($str, 0, 1).str_repeat('*', $len - 2);
}

if ($result_array['success'] != 0) {
    if ($is_anonymous == 1) {
        $report_response_sender_name = get_starred($report_response_sender_name);
    }

    $date_responded = date("Y-m-d h:iA", strtotime($date_responded));

    $options = array(
        'cluster' => 'ap1',
        'useTLS' => true
    );

    $pusher = new Pusher\Pusher(
        '8ff31fe73cdbafda41bc',
        '97b072e991cee5747e1b',
        '1275373',
        $options
    );

    $data = array(
        'report_response_sender_name' => $report_response_sender_name,
        'report_response_details' => $report_response_details,
        'date_responded' => $date_responded, 
        'transaction_id' => $transaction_id, 
        'admin_id' => $push_admin_id
    );

    $pusher->trigger('care-app-143', 'user-response', $data);
}

echo json_encode($result_array);

$conn -> close();

?>