<?php

include('../database/config.php');

session_start();

$email = $_SESSION['email'];
$new_password = ($conn -> real_escape_string($_POST['new_password'])) ? $conn -> real_escape_string($_POST['new_password']) : '';
$success = 0;

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
    echo "Query Error (fp_change_pass.php stmt1->prepare) : $stmt1->errno : $stmt1->error";
}

$conn -> close();

echo $success;

?>