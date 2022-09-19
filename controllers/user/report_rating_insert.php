<?php

include('../database/config.php');

$result_array = array();
$result_array['success'] = 1;
$result_array['message'] = "";

$transaction_id = ($conn -> real_escape_string($_POST['transaction_id'])) ? $conn -> real_escape_string($_POST['transaction_id']) : $result_array['success'] = 0;
$dept_id = ($conn -> real_escape_string($_POST['dept_id'])) ? $conn -> real_escape_string($_POST['dept_id']) : $result_array['success'] = 0;
$ratings = ($conn -> real_escape_string($_POST['ratings'])) ? $conn -> real_escape_string($_POST['ratings']) : $result_array['success'] = 0;

if ($result_array['success'] != 0) {

    // Create a prepared statement
    $stmt1 = $conn -> stmt_init();

    if ($stmt1 -> prepare(
        "INSERT INTO `report_ratings`(`transaction_id`, `dept_id`, `ratings`) VALUES (?,?,?)")) {

        // Bind parameters
        $stmt1 -> bind_param("sss", $transaction_id, $dept_id, $ratings);

        // Execute query
        $stmt1 -> execute();

        // Close statement
        $stmt1 -> close();

    } else {
        $result_array['success'] = 0;
        $result_array['message'] .= "Query Error (report_rating_insert.php stmt1->prepare) : $stmt1->errno : $stmt1->error";
    }

} else {
    $result_array['message'] .= "Please fill out the blank fields ";
}

if ($result_array['success'] != 0) {
    $result_array['success'] = 1;
    $result_array['message'] = "Success";
}

echo json_encode($result_array);

$conn -> close();

?>