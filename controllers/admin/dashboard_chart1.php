<?php

include('../database/config.php');

$barangays_array = array();
$number_of_residents_array = array();
$number_of_barangays = 0;

$data = array();

// Create a prepared statement
$stmt1 = $conn -> stmt_init();
$stmt2 = $conn -> stmt_init();

if ($stmt1 -> prepare("
SELECT barangay_name FROM `barangays`;")) {
    // Execute query
    $stmt1 -> execute();

    // Fetch values
    $result = $stmt1 -> get_result();
    $numRows = $result -> num_rows;
    if ($numRows > 0) {
        while($row = $result -> fetch_assoc()){
            array_push($barangays_array, $row['barangay_name']);
        }
    }

    // Close statement
    $stmt1 -> close();

    $number_of_barangays = count($barangays_array);

} else {
    echo "Query Error (dashboard_chart1.php stmt1->prepare) : $stmt1->errno : $stmt1->error";
}

if ($stmt2 -> prepare("
    SELECT COUNT(barangay_id)
    FROM `account_information`
    WHERE barangay_id = ? 
    AND admin_id = '' 
    AND is_deleted = 0;")) {

    for ($i = 1; $i <= $number_of_barangays; $i++) {
        // Bind parameters
        $stmt2 -> bind_param("s", $i);

        // Execute query
        $stmt2 -> execute();

        // Fetch values
        $result = $stmt2 -> get_result();
        $numRows = $result -> num_rows;
        if ($numRows > 0) {
            while($row = $result -> fetch_assoc()){
                array_push($number_of_residents_array, $row['COUNT(barangay_id)']);
            }
        }
    }

    // Close statement
    $stmt2 -> close();

} else {
    echo "Query Error (dashboard_chart1.php stmt2->prepare) : $stmt2->errno : $stmt2->error";
}

$data['barangays_array'] = $barangays_array;
$data['number_of_residents_array'] = $number_of_residents_array;

echo json_encode($data);

$conn -> close();

?>