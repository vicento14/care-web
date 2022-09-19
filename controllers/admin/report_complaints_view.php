<?php

//View

include('../database/config.php');

session_start();

$admin_id = $_SESSION['admin_id'];
$is_lock = 0;

$transaction_id = ($conn -> real_escape_string($_POST['transaction_id'])) ? $conn -> real_escape_string($_POST['transaction_id']) : '';
$user_id = "";
$user_account_id = "";
$user_account_name = "";
$user_email = "";
$user_cellphone_number = "";
$barangay_name = "";
$report_id = "";
$report_name = "";
$report_details = "";
$dept_name = "";
$admin_name = "";
$is_resolved = "";
$is_anonymous = 0;
$transaction_end_date = "";
$transaction_array = array();

// Create a prepared statement
$stmt1 = $conn -> stmt_init();
$stmt2 = $conn -> stmt_init();
$stmt3 = $conn -> stmt_init();

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
INNER JOIN `departments` ON assistance_transactions.dept_id = departments.dept_id 
WHERE assistance_transactions.transaction_id = ?;")) {
    // Bind parameters
    $stmt1 -> bind_param("s", $transaction_id);

    // Execute query
    $stmt1 -> execute();

    // Fetch values
    $result = $stmt1 -> get_result();
    while($row = $result -> fetch_assoc()){
        if ($row['is_resolved'] == 0) {
            $is_resolved = "pending";
        } else {
            $is_resolved = "resolved";
        }
        if ($admin_id == $row['admin_id']) {
            $is_lock = 1;
        } else if ($row['admin_id'] == 0) {
            $is_lock = 2;
        } else {
            $is_lock = 0;
        }
        $user_id = $row['user_id'];
        $user_account_id = $row['account_id'];
        $user_email = $row['email'];
        $user_cellphone_number = $row['cellphone_number'];
        $barangay_name = $row['barangay_name'];
        $report_id = $row['report_id'];
        $report_name = $row['report_name'];
        $report_details = $row['report_details'];
        $dept_name = $row['dept_name'];
        $v_admin_id = $row['admin_id'];
        $is_anonymous = intval($row['is_anonymous']);
        $transaction_end_date = $row['transaction_end_date'];
    }

    // Close statement
    $stmt1 -> close();

} else {
    echo "Query Error (report_complaints_view.php stmt1->prepare) : $stmt1->errno : $stmt1->error";
}

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
    echo "Query Error (report_complaints_view.php stmt2->prepare) : $stmt2->errno : $stmt2->error";
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
    echo "Query Error (report_complaints_view.php stmt3->prepare) : $stmt3->errno : $stmt3->error";
}

function get_starred($str) {
    $len = strlen($str);
    return substr($str, 0, 1).str_repeat('*', $len - 2);
}

function get_starred_phone($str) {
    $len = strlen($str);
    return str_repeat('*', $len - 2).substr($str, $len - 1, 1);
}

function hide_mail($email) {
    $mail_segments = explode("@", $email);
    $mail_segments[0] = str_repeat("*", strlen($mail_segments[0]));

    return implode("@", $mail_segments);
}

if ($is_anonymous == 1) {
    $user_account_name = get_starred($user_account_name);
    $user_email = hide_mail($user_email);
    if ($user_cellphone_number != "") {
        $user_cellphone_number = get_starred_phone($user_cellphone_number);
    }
}

$transaction_end_date = date("Y-m-d h:iA", strtotime($transaction_end_date));

$transaction_array = array(
    'user_id' => $user_id, 
    'user_account_name' => $user_account_name, 
    'user_email' => $user_email, 
    'user_cellphone_number' => $user_cellphone_number, 
    'barangay_name' => $barangay_name,
    'report_id' => $report_id, 
    'report_name' => $report_name, 
    'report_details' => $report_details, 
    'dept_name' => $dept_name, 
    'admin_name' => $admin_name, 
    'is_resolved' => $is_resolved, 
    'transaction_end_date' => $transaction_end_date, 
    'is_lock' => $is_lock);

echo json_encode($transaction_array, JSON_FORCE_OBJECT);

$conn -> close();

?>