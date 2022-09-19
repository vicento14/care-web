<?php

include('../database/config.php');

$year = date("Y");

$months_array = array("January","February","March","April","May","June","July","August","September","October","November","December");
$number_of_complaints_array = array();
$number_of_concerns_array = array();
$number_of_months = count($months_array);

$data = array();

// Create a prepared statement
$stmt1 = $conn -> stmt_init();
$stmt2 = $conn -> stmt_init();

if ($stmt1 -> prepare("
    SELECT COUNT(transaction_id) 
    FROM `assistance_transactions` 
    WHERE YEAR(transaction_end_date) = ?
    AND MONTH(transaction_end_date) = ? 
    AND report_type_id = 0")) {

    for ($i = 1; $i <= $number_of_months; $i++) {
        // Bind parameters
        $stmt1 -> bind_param("ss", $year, $i);

        // Execute query
        $stmt1 -> execute();

        // Fetch values
        $result = $stmt1 -> get_result();
        $numRows = $result -> num_rows;
        if ($numRows > 0) {
            while($row = $result -> fetch_assoc()){
                array_push($number_of_complaints_array, $row['COUNT(transaction_id)']);
            }
        }
    }

    // Close statement
    $stmt1 -> close();

} else {
    echo "Query Error (dashboard_chart4.php stmt1->prepare) : $stmt1->errno : $stmt1->error";
}

if ($stmt2 -> prepare("
    SELECT COUNT(transaction_id) 
    FROM `assistance_transactions` 
    WHERE YEAR(transaction_end_date) = ?
    AND MONTH(transaction_end_date) = ? 
    AND report_type_id = 1")) {

    for ($i = 1; $i <= $number_of_months; $i++) {
        // Bind parameters
        $stmt2 -> bind_param("ss", $year, $i);

        // Execute query
        $stmt2 -> execute();

        // Fetch values
        $result = $stmt2 -> get_result();
        $numRows = $result -> num_rows;
        if ($numRows > 0) {
            while($row = $result -> fetch_assoc()){
                array_push($number_of_concerns_array, $row['COUNT(transaction_id)']);
            }
        }
    }

    // Close statement
    $stmt2 -> close();

} else {
    echo "Query Error (dashboard_chart4.php stmt2->prepare) : $stmt2->errno : $stmt2->error";
}

$data['months_array'] = $months_array;
$data['number_of_complaints_array'] = $number_of_complaints_array;
$data['number_of_concerns_array'] = $number_of_concerns_array;

echo json_encode($data);

$conn -> close();

?>