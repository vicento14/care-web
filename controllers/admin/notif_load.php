<?php

include('../database/config.php');

session_start();

$account_id = $_SESSION['account_id'];

$data = array();

// Create a prepared statement
$stmt1 = $conn -> stmt_init();

if ($stmt1 -> prepare("
    SELECT cms_notif_info.notif_id, cms_notif_info.notif_date, 
    cms_notif_msg.notif_msg_details, cms_notif_info.from_account_id,
    assistance_transactions.transaction_id, 
    assistance_transactions.report_type_id, 
    report_types.report_type_name
    FROM `cms_notif_info`
    INNER JOIN `cms_notif_msg` ON cms_notif_info.notif_msg_id = cms_notif_msg.notif_msg_id
    INNER JOIN `assistance_transactions` ON cms_notif_info.transaction_id = assistance_transactions.transaction_id
    INNER JOIN `report_types` ON assistance_transactions.report_type_id = report_types.report_type_id
    WHERE cms_notif_info.to_account_id = ? 
    AND cms_notif_info.is_deleted = 0
    ORDER BY cms_notif_info.notif_date DESC;")) {
    // Bind parameters
    $stmt1 -> bind_param("s", $account_id);

    // Execute query
    $stmt1 -> execute();

    // Fetch values
    $result = $stmt1 -> get_result();
    while($row = $result -> fetch_assoc()){
        $index['notif_id'] = $row['notif_id'];
        $index['notif_date'] = date("Y-m-d h:iA", strtotime($row['notif_date']));
        $index['transaction_id'] = $row['transaction_id'];
        $index['report_type_id'] = $row['report_type_id'];
        $index['report_type_name'] = $row['report_type_name'];
        $index['from_account_id'] = $row['from_account_id'];
        $index['notif_msg_details'] = $row['notif_msg_details'];
        array_push($data, $index);
    }

    // Close statement
    $stmt1 -> close();
} else {
    echo "Query Error (notif_load.php stmt1->prepare) : $stmt1->errno : $stmt1->error";
}

echo json_encode($data, JSON_UNESCAPED_UNICODE);

$conn->close();

?>