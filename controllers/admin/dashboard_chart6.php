<?php

include('../database/config.php');

session_start();

$dept_id = $_SESSION['dept_id'];

$number_of_ratings = 1;

$report_positive = 0;
$report_neutral = 0;
$report_negative = 0;

$data = array();

// Create a prepared statement
$stmt2 = $conn -> stmt_init();
$stmt4 = $conn -> stmt_init();

if ($dept_id != 0) {
    if ($stmt2 -> prepare(
        "SELECT COUNT(transaction_id) FROM `report_ratings` WHERE dept_id = ? AND ratings = ?")) {
    
        for ($j = 3; $j >= $number_of_ratings; $j--) {
            // Bind parameters
            $stmt2 -> bind_param("ss", $dept_id, $j);
    
            // Execute query
            $stmt2 -> execute();
    
            // Fetch values
            $result = $stmt2 -> get_result();
            $numRows = $result -> num_rows;
            if ($numRows > 0) {
                while($row = $result -> fetch_assoc()){
                    if ($j == 3) {
                        $report_positive = intval($row['COUNT(transaction_id)']);
                    } else if ($j == 2) {
                        $report_neutral = intval($row['COUNT(transaction_id)']);
                    } else if ($j == 1) {
                        $report_negative = intval($row['COUNT(transaction_id)']);
                    }
                }
            }
        }
    
        // Close statement
        $stmt2 -> close();
    
    } else {
        echo "Query Error (dashboard_chart6.php stmt2->prepare) : $stmt2->errno : $stmt2->error";
    }
} else {
    if ($stmt4 -> prepare(
        "SELECT COUNT(transaction_id) FROM `report_ratings` WHERE ratings = ?")) {
    
        for ($j = 3; $j >= $number_of_ratings; $j--) {
            // Bind parameters
            $stmt4 -> bind_param("s", $j);
    
            // Execute query
            $stmt4 -> execute();
    
            // Fetch values
            $result = $stmt4 -> get_result();
            $numRows = $result -> num_rows;
            if ($numRows > 0) {
                while($row = $result -> fetch_assoc()){
                    if ($j == 3) {
                        $report_positive = intval($row['COUNT(transaction_id)']);
                    } else if ($j == 2) {
                        $report_neutral = intval($row['COUNT(transaction_id)']);
                    } else if ($j == 1) {
                        $report_negative = intval($row['COUNT(transaction_id)']);
                    }
                }
            }
        }
    
        // Close statement
        $stmt4 -> close();
    
    } else {
        echo "Query Error (dashboard_chart6.php stmt4->prepare) : $stmt4->errno : $stmt4->error";
    }
}

$data['report_positive'] = $report_positive;
$data['report_neutral'] = $report_neutral;
$data['report_negative'] = $report_negative;

echo json_encode($data);

$conn -> close();

?>