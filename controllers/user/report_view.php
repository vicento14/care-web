<?php

include('../database/config.php');

$result_array = array();
$result_array['transaction_array'] = array();
$upload_array = array();
$result_array['success'] = 1;
$result_array['message'] = "";

$transaction_id = ($conn -> real_escape_string($_POST['transaction_id'])) ? $conn -> real_escape_string($_POST['transaction_id']) : $result_array['success'] = 0;
$user_id = 0;
$user_account_id = 0;
$user_account_name = "";
$user_email = "";
$user_cellphone_number = "";
$barangay_name = "";
$report_id = 0;
$report_name = "";
$report_details = "";
$report_type_id = 0;
$report_type_name = "";
$dept_id = 0;
$dept_name = "";
$admin_name = "";
$is_resolved = 0;
$transaction_end_date = "";
$upload_set_id = 0;
$upload_filename = "";
$upload_filetype = "";
$upload_url = "";
$has_upload = "0";

if ($result_array['success'] != 0) {

    // Create a prepared statement
    $stmt1 = $conn -> stmt_init();
    $stmt2 = $conn -> stmt_init();
    $stmt3 = $conn -> stmt_init();
    $stmt4 = $conn -> stmt_init();

    if ($stmt1 -> prepare("
    SELECT assistance_transactions.transaction_id, 
    assistance_transactions.user_id, 
    account_information.account_id, 
    account_information.email, 
    account_information.cellphone_number, 
    barangays.barangay_name, 
    assistance_transactions.report_id, 
    reports.report_name, 
    reports.report_details, 
    assistance_transactions.report_type_id, 
    report_types.report_type_name, 
    assistance_transactions.report_convo_id, 
    assistance_transactions.upload_set_id, 
    assistance_transactions.dept_id, 
    departments.dept_name, 
    assistance_transactions.admin_id,  
    assistance_transactions.is_resolved, 
    assistance_transactions.is_anonymous, 
    assistance_transactions.transaction_start_date, 
    assistance_transactions.transaction_end_date 
    FROM `assistance_transactions` 
    INNER JOIN `account_information` ON assistance_transactions.user_id = account_information.user_id 
    INNER JOIN `barangays` ON assistance_transactions.barangay_id = barangays.barangay_id 
    INNER JOIN `reports` ON assistance_transactions.report_id = reports.report_id 
    INNER JOIN `report_types` ON assistance_transactions.report_type_id = report_types.report_type_id 
    INNER JOIN `departments` ON assistance_transactions.dept_id = departments.dept_id 
    WHERE assistance_transactions.transaction_id = ?;")) {
        // Bind parameters
        $stmt1 -> bind_param("s", $transaction_id);

        // Execute query
        $stmt1 -> execute();

        // Fetch values
        $result = $stmt1 -> get_result();
        $numRows = $result -> num_rows;
        if ($numRows > 0) {
            while($row = $result -> fetch_assoc()){
                if ($row['is_resolved'] == 0) {
                    $is_resolved = "pending";
                } else {
                    $is_resolved = "resolved";
                }
                $user_id = $row['user_id'];
                $user_account_id = $row['account_id'];
                $user_email = $row['email'];
                $user_cellphone_number = $row['cellphone_number'];
                $barangay_name = $row['barangay_name'];
                $report_id = $row['report_id'];
                $report_name = $row['report_name'];
                $report_details = $row['report_details'];
                $report_type_id = $row['report_type_id'];
                $report_type_name = $row['report_type_name'];
                $upload_set_id = $row['upload_set_id'];
                $dept_id = $row['dept_id'];
                $dept_name = $row['dept_name'];
                $v_admin_id = $row['admin_id'];
                $transaction_end_date = $row['transaction_end_date'];
            }
        } else {
            $result_array['success'] = 0;
            $result_array['message'] = "Not Found";
        }

        // Close statement
        $stmt1 -> close();

    } else {
        $result_array['success'] = 0;
        $result_array['message'] .= "Query Error (report_view.php stmt1->prepare) : $stmt1->errno : $stmt1->error";
    }

    if ($result_array['success'] != 0) {

        if ($stmt2 -> prepare("
        SELECT admin_name
        FROM `admins`
        WHERE admin_id = ?;")) {
            // Bind parameters
            $stmt2 -> bind_param("s", $v_admin_id);

            // Execute query
            $stmt2 -> execute();

            // Fetch values
            $result = $stmt2 -> get_result();
            $numRows = $result -> num_rows;
            if ($numRows > 0) {
                while($row = $result -> fetch_assoc()){
                    $admin_name = $row['admin_name'];
                }
            }

            // Close statement
            $stmt2 -> close();

        } else {
            $result_array['success'] = 0;
            $result_array['message'] .= "Query Error (report_view.php stmt2->prepare) : $stmt2->errno : $stmt2->error";
        }

        if ($stmt3 -> prepare("
        SELECT account_name
        FROM `accounts`
        WHERE account_id = ?;")) {
            // Bind parameters
            $stmt3 -> bind_param("s", $user_account_id);

            // Execute query
            $stmt3 -> execute();

            // Fetch values
            $result = $stmt3 -> get_result();
            while($row = $result -> fetch_assoc()){
                $user_account_name = $row['account_name'];
            }

            // Close statement
            $stmt3 -> close();

        } else {
            $result_array['success'] = 0;
            $result_array['message'] .= "Query Error (report_view.php stmt3->prepare) : $stmt3->errno : $stmt3->error";
        }

        if ($stmt4 -> prepare("
        SELECT * 
        FROM `uploads` 
        WHERE upload_set_id = ?;")) {
            // Bind parameters
            $stmt4 -> bind_param("s", $upload_set_id);

            // Execute query
            $stmt4 -> execute();

            // Fetch values
            $result = $stmt4 -> get_result();
            $numRows = $result -> num_rows;
            if ($numRows > 0) {
                while($row = $result -> fetch_assoc()){
                    $upload_filename = $row['upload_filename'];
                    $upload_filetype = $row['upload_filetype'];
                    $upload_url = $row['upload_url'];
                    $has_upload = "1";
                }
            } else {
                $has_upload = "0";
            }

            // Close statement
            $stmt4 -> close();

        } else {
            $result_array['success'] = 0;
            $result_array['message'] .= "Query Error (report_view.php stmt4->prepare) : $stmt4->errno : $stmt4->error";
        }

        $index1['upload_filename'] = $upload_filename;
        $index1['upload_filetype'] = $upload_filetype;
        $index1['upload_url'] = $upload_url;
        $index1['has_upload'] = $has_upload;

        array_push($upload_array, $index1);

        $index['upload_array'] = $upload_array;

        $index['user_id'] = $user_id;
        $index['user_account_name'] = $user_account_name;
        $index['user_email'] = $user_email;
        $index['user_cellphone_number'] = $user_cellphone_number;
        $index['barangay_name'] = $barangay_name;
        $index['report_id'] = $report_id;
        $index['report_name'] = $report_name;
        $index['report_details'] = $report_details; 
        $index['report_type_id'] = $report_type_id;
        $index['report_type_name'] = $report_type_name;
        $index['dept_id'] = $dept_id;
        $index['dept_name'] = $dept_name;
        $index['admin_name'] = $admin_name;
        $index['is_resolved'] = $is_resolved;
        $index['transaction_end_date'] = date("Y-m-d h:iA", strtotime($transaction_end_date));
        
        array_push($result_array['transaction_array'], $index);
    }

} else {
    $result_array['message'] .= "Please fill out the blank fields";
}

if ($result_array['success'] != 0) {
    $result_array['success'] = 1;
    $result_array['message'] = "Success";
}

echo json_encode($result_array, JSON_UNESCAPED_SLASHES);

$conn -> close();

?>