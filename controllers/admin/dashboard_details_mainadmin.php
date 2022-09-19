<?php

include('../database/config.php');

$total_complaints = 0;
$total_concerns = 0;
$total_dept = 0;
$total_brgy = 0;

$data = array();

// Create a prepared statement
$stmt1 = $conn -> stmt_init();
$stmt2 = $conn -> stmt_init();
$stmt3 = $conn -> stmt_init();
$stmt4 = $conn -> stmt_init();

if ($stmt1 -> prepare("
SELECT COUNT(transaction_id)
FROM `assistance_transactions`
WHERE report_type_id = 0;")) {
    // Execute query
    $stmt1 -> execute();

    // Fetch values
    $result = $stmt1 -> get_result();
    $numRows = $result -> num_rows;
    if ($numRows > 0) {
        while($row = $result -> fetch_assoc()){
            $total_complaints = $row['COUNT(transaction_id)'];
        }
    }

    // Close statement
    $stmt1 -> close();

} else {
    echo "Query Error (dashboard_details_mainadmin.php stmt1->prepare) : $stmt1->errno : $stmt1->error";
}

if ($stmt2 -> prepare("
SELECT COUNT(transaction_id)
FROM `assistance_transactions`
WHERE report_type_id = 1;")) {
    // Execute query
    $stmt2 -> execute();

    // Fetch values
    $result = $stmt2 -> get_result();
    $numRows = $result -> num_rows;
    if ($numRows > 0) {
        while($row = $result -> fetch_assoc()){
            $total_concerns = $row['COUNT(transaction_id)'];
        }
    }

    // Close statement
    $stmt2 -> close();

} else {
    echo "Query Error (dashboard_details_mainadmin.php stmt2->prepare) : $stmt2->errno : $stmt2->error";
}

if ($stmt3 -> prepare("
SELECT COUNT(dept_id)
FROM `departments` 
WHERE dept_id != 0;")) {
    // Execute query
    $stmt3 -> execute();

    // Fetch values
    $result = $stmt3 -> get_result();
    $numRows = $result -> num_rows;
    if ($numRows > 0) {
        while($row = $result -> fetch_assoc()){
            $total_dept = $row['COUNT(dept_id)'];
        }
    }

    // Close statement
    $stmt3 -> close();

} else {
    echo "Query Error (dashboard_details_mainadmin.php stmt3->prepare) : $stmt3->errno : $stmt3->error";
}

if ($stmt4 -> prepare("
SELECT COUNT(barangay_id)
FROM `barangays`;")) {
    // Execute query
    $stmt4 -> execute();

    // Fetch values
    $result = $stmt4 -> get_result();
    $numRows = $result -> num_rows;
    if ($numRows > 0) {
        while($row = $result -> fetch_assoc()){
            $total_brgy = $row['COUNT(barangay_id)'];
        }
    }

    // Close statement
    $stmt4 -> close();

} else {
    echo "Query Error (dashboard_details_mainadmin.php stmt4->prepare) : $stmt4->errno : $stmt4->error";
}

$data['total_complaints'] = $total_complaints;
$data['total_concerns'] = $total_concerns;
$data['total_dept'] = $total_dept;
$data['total_brgy'] = $total_brgy;

echo json_encode($data);

$conn -> close();

?>