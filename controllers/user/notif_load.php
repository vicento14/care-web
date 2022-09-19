<?php

include('../database/config.php');

$result_array = array();
$result_array['data'] = array();
$result_array['success'] = 1;
$result_array['message'] = "";

$account_id = ($conn -> real_escape_string($_POST['account_id'])) ? $conn -> real_escape_string($_POST['account_id']) : $result_array['success'] = 0;

if ($result_array['success'] != 0) {

    // Create a prepared statement
    $stmt1 = $conn -> stmt_init();

    if ($stmt1 -> prepare("
        SELECT cms_notif_info.notif_id, cms_notif_info.notif_date, 
        cms_notif_msg.notif_msg_details, cms_notif_info.from_account_id,
        assistance_transactions.transaction_id, 
        assistance_transactions.admin_id, 
        assistance_transactions.dept_id, 
        assistance_transactions.user_id, 
        assistance_transactions.report_type_id, 
        report_types.report_type_name
        FROM `cms_notif_info`
        INNER JOIN `cms_notif_msg` ON cms_notif_info.notif_msg_id = cms_notif_msg.notif_msg_id
        INNER JOIN `assistance_transactions` ON cms_notif_info.transaction_id = assistance_transactions.transaction_id
        INNER JOIN `report_types` ON assistance_transactions.report_type_id = report_types.report_type_id
        WHERE cms_notif_info.to_account_id = ? 
        AND cms_notif_info.is_deleted = 0;")) {
        // Bind parameters
        $stmt1 -> bind_param("s", $account_id);

        // Execute query
        $stmt1 -> execute();

        // Fetch values
        $result = $stmt1 -> get_result();
        $numRows = $result -> num_rows;
        if ($numRows > 0) {
            while($row = $result -> fetch_assoc()){
                $index['notif_id'] = $row['notif_id'];
                $index['notif_date'] = date("Y-m-d h:iA", strtotime($row['notif_date']));
                $index['notif_msg_details'] = $row['notif_msg_details'];
                $index['from_account_id'] = $row['from_account_id'];
                $index['transaction_id'] = $row['transaction_id'];
                $index['report_type_id'] = $row['report_type_id'];
                $index['report_type_name'] = $row['report_type_name'];
                $index['admin_id'] = $row['admin_id'];
                $index['dept_id'] = $row['dept_id'];
                $index['user_id'] = $row['user_id'];
                array_push($result_array['data'], $index);
            }
        } else {
            $result_array['success'] = 0;
            $result_array['message'] .= "No Notifications Available";
        }

        // Close statement
        $stmt1 -> close();
    } else {
        $result_array['success'] = 0;
        $result_array['message'] .= "Query Error (notif_load.php stmt1->prepare) : $stmt1->errno : $stmt1->error";
    }

} else {
    $result_array['message'] .= "Please fill out the blank fields ";
}

if ($result_array['success'] != 0) {
    $result_array['success'] = 1;
    $result_array['message'] = "Success";
}

echo json_encode($result_array, JSON_UNESCAPED_UNICODE);

$conn->close();

?>