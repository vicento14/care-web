<?php
include('../database/config.php');

$result_array = array();
$result_array['session'] = array();
$result_array['success'] = 1;
$result_array['message'] = "";

$account_id = ($conn -> real_escape_string($_POST['account_id'])) ? $conn -> real_escape_string($_POST['account_id']) : $result_array['success'] = 0;

if ($result_array['success'] != 0) {

    // Create a prepared statement
    $stmt1 = $conn -> stmt_init();

    if ($stmt1 -> prepare(
        "UPDATE `account_information` 
        SET active = 0 
        WHERE account_id = ?;")) {
        
        // Bind parameters
        $stmt1 -> bind_param("s", $account_id);

        // Execute query
        $stmt1 -> execute();

        // Close statement
        $stmt1 -> close();

        $result_array['message'] = "Success";

    } else {
        $result_array['success'] = 0;
        $result_array['message'] .= "Query Error (sign-out.php stmt1->prepare) : $stmt1->errno : $stmt1->error";
    }

} else {
    $result_array['message'] .= "Please fill out the blank fields";
}

echo json_encode($result_array);

$conn -> close();

?>