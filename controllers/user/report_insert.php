<?php

include('../database/config.php');
require_once './notif_insert.php';

$result_array = array();
$result_array['success'] = 1;
$result_array['message'] = "";
$result_array['data'] = array();

$report_id = 0;
$report_name = ($_POST['report_name']) ? $_POST['report_name'] : $result_array['success'] = 0;
$report_details = ($_POST['report_details']) ? $_POST['report_details'] : $result_array['success'] = 0;

$transaction_id = 0;
$user_id = ($conn -> real_escape_string($_POST['user_id'])) ? $conn -> real_escape_string($_POST['user_id']) : $result_array['success'] = 0;
$barangay_id = ($conn -> real_escape_string($_POST['barangay_id'])) ? $conn -> real_escape_string($_POST['barangay_id']) : $result_array['success'] = 0;
$report_type_id = ($conn -> real_escape_string($_POST['report_type_id'])) ? $conn -> real_escape_string($_POST['report_type_id']) : $result_array['success'] = 0;
$report_method_id = 0;
$report_convo_id = 0;
$upload_set_id = 0;
$dept_id = ($conn -> real_escape_string($_POST['dept_id'])) ? $conn -> real_escape_string($_POST['dept_id']) : $result_array['success'] = 0;
$admin_id = 0;
$is_anonymous = ($conn -> real_escape_string($_POST['is_anonymous'])) ? $conn -> real_escape_string($_POST['is_anonymous']) : $result_array['success'] = 0;
date_default_timezone_set("Asia/Manila");
$transaction_end_date = date('Y-m-d H:i:s');

$report_left = 0;
$report_datetime = "";
$report_date = "";
$date_now = date('Y-m-d');

if ($result_array['success'] != 0) {

    // decrement 2 into 1 and 1 into 0
    $report_type_id--;
    $is_anonymous--;
    
    // Create a prepared statement
    $stmt1 = $conn -> stmt_init();
    $stmt2 = $conn -> stmt_init();
    $stmt3 = $conn -> stmt_init();
    $stmt4 = $conn -> stmt_init();
    $stmt5 = $conn -> stmt_init();
    $stmt6 = $conn -> stmt_init();
    $stmt7 = $conn -> stmt_init();
    $stmt8 = $conn -> stmt_init();

    if ($stmt1 -> prepare("SELECT report_left, report_date FROM `users` WHERE user_id = ?")) {
        // Bind parameters
        $stmt1 -> bind_param("s", $user_id);

        // Execute query
        $stmt1 -> execute();

        // Fetch values
        $result = $stmt1 -> get_result();
        while($row = $result -> fetch_assoc()){
            $report_left = intval($row['report_left']);
            $report_datetime = $row['report_date'];
            $report_date = date_create($report_datetime);
            $report_date = date_format($report_date,"Y-m-d");
        }

        if ($report_left < 1) {
            if ($report_date < $date_now) {
                $report_left = 9;
                $report_datetime = date('Y-m-d H:i:s');
            } else {
                $result_array['success'] = 0;
                $result_array['message'] .= "You have submitted 10 reports today. Try again tomorrow.";
            }
        } else if ($report_datetime == "0000-00-00 00:00:00") {
            $report_datetime = date('Y-m-d H:i:s');
            $report_left--;
        } else {
            $report_left--;
        }

        // Close statement
        $stmt1 -> close();
    } else {
        $result_array['success'] = 0;
        $result_array['message'] .= "Query Error (report_insert.php stmt1->prepare) : $stmt1->errno : $stmt1->error";
    }

    if ($stmt2 -> prepare("UPDATE `users` SET report_left = ?, report_date = ? WHERE user_id = ?;")) {
        // Bind parameters
        $stmt2 -> bind_param("sss", $report_left, $report_datetime, $user_id);

        // Execute query
        $stmt2 -> execute();

        // Close statement
        $stmt2 -> close();
    } else {
        $result_array['success'] = 0;
        $result_array['message'] .= "Query Error (report_insert.php stmt2->prepare) : $stmt2->errno : $stmt2->error";
    }

    if ($stmt3 -> prepare("SELECT report_id FROM `reports` ORDER BY report_id DESC LIMIT 1;")) {
        // Execute query
        $stmt3 -> execute();

        // Fetch values
        $result = $stmt3 -> get_result();
        $numRows = $result -> num_rows;
        if ($numRows > 0) {
            while($row = $result -> fetch_assoc()){
                $report_id = intval($row['report_id']);
            }
        }

        // Close statement
        $stmt3 -> close();

        $report_id++;

    } else {
        $result_array['success'] = 0;
        $result_array['message'] .= "Query Error (report_insert.php stmt3->prepare) : $stmt3->errno : $stmt3->error";
    }

    if ($stmt4 -> prepare("SELECT report_convo_id FROM `assistance_transactions` ORDER BY report_convo_id DESC LIMIT 1;")) {
        // Execute query
        $stmt4 -> execute();

        // Fetch values
        $result = $stmt4 -> get_result();
        $numRows = $result -> num_rows;
        if ($numRows > 0) {
            while($row = $result -> fetch_assoc()){
                $report_convo_id = intval($row['report_convo_id']);
            }
        }

        // Close statement
        $stmt4 -> close();

        $report_convo_id++;

    } else {
        $result_array['success'] = 0;
        $result_array['message'] .= "Query Error (report_insert.php stmt4->prepare) : $stmt4->errno : $stmt4->error";
    }

    if ($stmt5 -> prepare("SELECT upload_set_id FROM `assistance_transactions` ORDER BY upload_set_id DESC LIMIT 1;")) {
        // Execute query
        $stmt5 -> execute();

        // Fetch values
        $result = $stmt5 -> get_result();
        $numRows = $result -> num_rows;
        if ($numRows > 0) {
            while($row = $result -> fetch_assoc()){
                $upload_set_id = intval($row['upload_set_id']);
            }
        }

        // Close statement
        $stmt5 -> close();

        $upload_set_id++;

    } else {
        $result_array['success'] = 0;
        $result_array['message'] .= "Query Error (report_insert.php stmt5->prepare) : $stmt5->errno : $stmt5->error";
    }

    if ($stmt6 -> prepare("SELECT transaction_id FROM `assistance_transactions` ORDER BY transaction_id DESC LIMIT 1;")) {
        // Execute query
        $stmt6 -> execute();

        // Fetch values
        $result = $stmt6 -> get_result();
        $numRows = $result -> num_rows;
        if ($numRows > 0) {
            while($row = $result -> fetch_assoc()){
                $transaction_id = intval($row['transaction_id']);
            }
        }

        // Close statement
        $stmt6 -> close();

        $transaction_id++;

    } else {
        $result_array['success'] = 0;
        $result_array['message'] .= "Query Error (report_insert.php stmt6->prepare) : $stmt6->errno : $stmt6->error";
    }

    if ($result_array['success'] != 0) {
        if ($stmt7 -> prepare(
        "INSERT INTO `reports` (report_id, report_name, report_details) 
        VALUES (?, ?, ?);")) {
            // Bind parameters
            $stmt7 -> bind_param("sss", $report_id, $report_name, $report_details);

            // Execute query
            $stmt7 -> execute();

            // Close statement
            $stmt7 -> close();
        } else {
            $result_array['success'] = 0;
            $result_array['message'] .= "Query Error (report_insert.php stmt7->prepare) : $stmt7->errno : $stmt7->error";
        }

        if ($stmt8 -> prepare(
        "INSERT INTO `assistance_transactions` 
        (transaction_id, user_id, barangay_id, 
        report_id, report_type_id, report_method_id, 
        report_convo_id, upload_set_id, dept_id, 
        admin_id, is_resolved, is_anonymous, 
        is_read, is_read_date, transaction_start_date, transaction_end_date) 
        VALUES (?, ?, ?, ?, ?, ?, ?, ?, ?, ?, 0, ?, 0, '0000-00-00 00:00:00', '0000-00-00 00:00:00',?);")) {
            // Bind parameters
            $stmt8 -> bind_param("ssssssssssss", $transaction_id, 
            $user_id, $barangay_id, $report_id, $report_type_id, 
            $report_method_id, $report_convo_id, $upload_set_id, 
            $dept_id, $admin_id, $is_anonymous, $transaction_end_date);

            // Execute query
            $stmt8 -> execute();

            // Close statement
            $stmt8 -> close();
        } else {
            $result_array['success'] = 0;
            $result_array['message'] .= "Query Error (report_insert.php stmt8->prepare) : $stmt8->errno : $stmt8->error";
        }
    }

} else {
    $result_array['message'] .= "Please fill out the blank fields";
}

if ($result_array['success'] != 0) {
    $result_array['success'] = notif_insert(2, $transaction_id);
}

$index['transaction_id'] = $transaction_id;
array_push($result_array['data'], $index);

if ($result_array['success'] != 0) {
    $result_array['success'] = 1;
    $result_array['message'] = "Success";
}

echo json_encode($result_array);

$conn -> close();

?>