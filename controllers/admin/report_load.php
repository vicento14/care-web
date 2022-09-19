<?php

include('../database/config.php');

session_start();

$dept_id = $_SESSION['dept_id'];
$data = array();
$is_resolved = "";

// Create a prepared statement
$stmt1 = $conn -> stmt_init();

if ($stmt1 -> prepare("
SELECT assistance_transactions.transaction_id, 
assistance_transactions.user_id, 
barangays.barangay_name, 
assistance_transactions.report_type_id, 
report_types.report_type_name, 
assistance_transactions.dept_id, 
assistance_transactions.is_resolved, 
assistance_transactions.transaction_end_date 
FROM `assistance_transactions` 
INNER JOIN `barangays` ON assistance_transactions.barangay_id = barangays.barangay_id 
INNER JOIN `report_types` ON assistance_transactions.report_type_id = report_types.report_type_id 
WHERE assistance_transactions.dept_id = ?")) {
    // Bind parameters
    $stmt1 -> bind_param("s", $dept_id);

    // Execute query
    $stmt1 -> execute();

    // Fetch values
    $result = $stmt1 -> get_result();
    while($row = $result -> fetch_assoc()){
        $index['transaction_id'] = $row['transaction_id'];
        $index['user_id'] = $row['user_id'];
        $index['barangay_name'] = $row['barangay_name'];
        $index['report_type_id'] = $row['report_type_id'];
        $index['report_type_name'] = $row['report_type_name'];
        $index['dept_id'] = $row['dept_id'];
        $index['is_resolved'] = $row['is_resolved'];
        $index['transaction_end_date'] = date("Y-m-d h:iA", strtotime($row['transaction_end_date']));
        array_push($data, $index);
    }

    // Close statement
    $stmt1 -> close();

} else {
    echo "Query Error (report_load.php stmt1->prepare) : $stmt1->errno : $stmt1->error";
}

echo json_encode($data, JSON_UNESCAPED_UNICODE);

$conn->close();

?>