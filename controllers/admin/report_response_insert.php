<?php

//Insert

include('../database/config.php');
require_once './notif_insert.php';
include('../../vendor/autoload.php');

session_start();

$report_response_sender_name = $_SESSION['account_name'];

$transaction_id = ($conn -> real_escape_string($_POST['transaction_id'])) ? $conn -> real_escape_string($_POST['transaction_id']) : '';
$report_response_id = 0;
$report_response_details = ($_POST['report_response_details']) ? $_POST['report_response_details'] : '';
$user_id = 0;
$push_user_id = 0;
$admin_id = $_SESSION['admin_id'];
$report_convo_id = "";
$response_msg = "";
$dept_id = $_SESSION['dept_id'];
$dept_admins_array = array();

date_default_timezone_set("Asia/Manila");
$date_responded = date('Y-m-d H:i:s');

// Create a prepared statement
$stmt1 = $conn -> stmt_init();
$stmt2 = $conn -> stmt_init();
$stmt3 = $conn -> stmt_init();
$stmt4 = $conn -> stmt_init();

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
    echo "Query Error (report_response_insert.php stmt1->prepare) : $stmt1->errno : $stmt1->error";
    $response_msg = "failed";
}

if ($stmt2 -> prepare("
SELECT transaction_id, user_id, 
report_convo_id, admin_id 
FROM `assistance_transactions` 
WHERE transaction_id = ?;")) {
    // Bind parameters
    $stmt2 -> bind_param("s", $transaction_id);

    // Execute query
    $stmt2 -> execute();

    // Fetch values
    $result = $stmt2 -> get_result();
    while($row = $result -> fetch_assoc()){
        $report_convo_id = $row['report_convo_id'];
        $admin_id = $row['admin_id'];
        $push_user_id = intval($row['user_id']);
    }

    // Close statement
    $stmt2 -> close();

    $response_msg = "success";

} else {
    echo "Query Error (report_response_insert.php stmt2->prepare) : $stmt2->errno : $stmt2->error";
    $response_msg = "failed";
}

if ($response_msg != "failed") {
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

        $response_msg = "success";

    } else {
        echo "Query Error (report_response_insert.php stmt3->prepare) : $stmt3->errno : $stmt3->error";
        $response_msg = "failed";
    }
} else {
    echo "transaction_id not found. ";
}

if ($response_msg != "failed") {
    notif_insert(1, $transaction_id, $admin_id);
}

if ($stmt4 -> prepare(
    "SELECT admin_id FROM `admins_departments` 
    WHERE dept_id = ?;")) {
    // Bind parameters
    $stmt4 -> bind_param("s", $dept_id);
    
    // Execute query
    $stmt4 -> execute();

    // Fetch values
    $result = $stmt4 -> get_result();
    $numRows = $result -> num_rows;
    if ($numRows > 0) {
        while($row = $result -> fetch_assoc()){
            array_push($dept_admins_array, intval($row['admin_id']));
        }
    } else {
        $response_msg = "failed";
    }

    // Close statement
    $stmt4 -> close();
} else {
    echo "Query Error (report_response_insert.php stmt4->prepare) : $stmt4->errno : $stmt4->error";
    $response_msg = "failed";
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
    'sender' => $report_response_sender_name,
    'body' => $report_response_details,
    'sent' => $date_responded, 
    'transaction_id' => $transaction_id,
    'user_id' => $push_user_id
);

$pusher->trigger('care-app-143', 'admin-response', $data);

foreach ($dept_admins_array as $admin) {

    $data2 = array(
        'report_response_sender_name' => $report_response_sender_name,
        'report_response_details' => $report_response_details,
        'date_responded' => $date_responded, 
        'transaction_id' => $transaction_id,
        'admin_id' => $admin
    );

    $pusher->trigger('care-app-143', 'admin-response-web', $data2);

}

echo $response_msg;

$conn -> close();

?>