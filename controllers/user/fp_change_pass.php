<?php

include('../database/config.php');

session_start();

$result_array = array();
$result_array['success'] = 1;
$result_array['message'] = "";

$email = $_SESSION['email'];
$new_password = ($conn -> real_escape_string($_POST['new_password'])) ? $conn -> real_escape_string($_POST['new_password']) : $result_array['success'] = 0;

if ($result_array['success'] != 0) {

    // password hash algorithm
    $new_password = hash('sha512', $new_password);

    // Create a prepared statement
    $stmt1 = $conn -> stmt_init();

    if ($stmt1 -> prepare("UPDATE `account_auths` SET password = ? WHERE user_email = ?;")) {
        // Bind parameters
        $stmt1 -> bind_param("ss", $new_password, $email);

        // Execute query
        $stmt1 -> execute();

        // Close statement
        $stmt1 -> close();

        $success = 1;

    } else {
        $result_array['success'] = 0;
        $result_array['message'] .= "Query Error (fp_change_pass.php stmt1->prepare) : $stmt1->errno : $stmt1->error";
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