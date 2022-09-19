<?php

include('../database/config.php');

$dept_array = array();
$number_of_complaints_array = array();
$number_of_concerns_array = array();
$number_of_dept = 0;

$data = array();

// Create a prepared statement
$stmt1 = $conn -> stmt_init();
$stmt2 = $conn -> stmt_init();
$stmt3 = $conn -> stmt_init();

if ($stmt1 -> prepare("
SELECT dept_name FROM `departments` WHERE dept_id != 0;")) {
    // Execute query
    $stmt1 -> execute();

    // Fetch values
    $result = $stmt1 -> get_result();
    $numRows = $result -> num_rows;
    if ($numRows > 0) {
        while($row = $result -> fetch_assoc()){
            array_push($dept_array, $row['dept_name']);
        }
    }

    // Close statement
    $stmt1 -> close();

    $number_of_dept = count($dept_array);

} else {
    echo "Query Error (dashboard_chart3.php stmt1->prepare) : $stmt1->errno : $stmt1->error";
}

if ($stmt2 -> prepare("
    SELECT COUNT(dept_id)
    FROM `assistance_transactions`
    WHERE dept_id = ? 
    AND report_type_id = 0;")) {

    for ($i = 1; $i <= $number_of_dept; $i++) {
        // Bind parameters
        $stmt2 -> bind_param("s", $i);

        // Execute query
        $stmt2 -> execute();

        // Fetch values
        $result = $stmt2 -> get_result();
        $numRows = $result -> num_rows;
        if ($numRows > 0) {
            while($row = $result -> fetch_assoc()){
                array_push($number_of_complaints_array, $row['COUNT(dept_id)']);
            }
        }
    }

    // Close statement
    $stmt2 -> close();

} else {
    echo "Query Error (dashboard_chart3.php stmt2->prepare) : $stmt2->errno : $stmt2->error";
}

if ($stmt3 -> prepare("
    SELECT COUNT(dept_id)
    FROM `assistance_transactions`
    WHERE dept_id = ? 
    AND report_type_id = 1;")) {

    for ($i = 1; $i <= $number_of_dept; $i++) {
        // Bind parameters
        $stmt3 -> bind_param("s", $i);

        // Execute query
        $stmt3 -> execute();

        // Fetch values
        $result = $stmt3 -> get_result();
        $numRows = $result -> num_rows;
        if ($numRows > 0) {
            while($row = $result -> fetch_assoc()){
                array_push($number_of_concerns_array, $row['COUNT(dept_id)']);
            }
        }
    }

    // Close statement
    $stmt3 -> close();

} else {
    echo "Query Error (dashboard_chart3.php stmt3->prepare) : $stmt3->errno : $stmt3->error";
}

$data['dept_array'] = $dept_array;
$data['number_of_complaints_array'] = $number_of_complaints_array;
$data['number_of_concerns_array'] = $number_of_concerns_array;

echo json_encode($data);

$conn -> close();

?>