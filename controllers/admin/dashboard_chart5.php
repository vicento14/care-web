<?php

include('../database/config.php');

$number_of_ratings = 1;

$app_positive = 0;
$app_neutral = 0;
$app_negative = 0;

$data = array();

// Create a prepared statement
$stmt2 = $conn -> stmt_init();

if ($stmt2 -> prepare(
    "SELECT COUNT(user_id) FROM `app_ratings` WHERE ratings = ?")) {

    for ($j = 3; $j >= $number_of_ratings; $j--) {
        // Bind parameters
        $stmt2 -> bind_param("s", $j);

        // Execute query
        $stmt2 -> execute();

        // Fetch values
        $result = $stmt2 -> get_result();
        $numRows = $result -> num_rows;
        if ($numRows > 0) {
            while($row = $result -> fetch_assoc()){
                if ($j == 3) {
                    $app_positive = intval($row['COUNT(user_id)']);
                } else if ($j == 2) {
                    $app_neutral = intval($row['COUNT(user_id)']);
                } else if ($j == 1) {
                    $app_negative = intval($row['COUNT(user_id)']);
                }
            }
        }
    }

    // Close statement
    $stmt2 -> close();

} else {
    echo "Query Error (dashboard_chart5.php stmt2->prepare) : $stmt2->errno : $stmt2->error";
}

$data['app_positive'] = $app_positive;
$data['app_neutral'] = $app_neutral;
$data['app_negative'] = $app_negative;

echo json_encode($data);

$conn -> close();

?>