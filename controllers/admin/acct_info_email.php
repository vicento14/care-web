<?php
include('../database/config.php');

session_start();

$email = ($conn -> real_escape_string($_POST['email'])) ? $conn -> real_escape_string($_POST['email']) : '';
$user_email = $email;

// Create a prepared statement
$stmt1 = $conn -> stmt_init();
$stmt2 = $conn -> stmt_init();

if ($stmt1 -> prepare("UPDATE `account_information` SET email = ? WHERE account_id = ?;")) {
    // Bind parameters
    $stmt1 -> bind_param("ss", $email, $_SESSION['account_id']);

    // Execute query
    $stmt1 -> execute();

    $_SESSION['email'] = $email;

    // Close statement
    $stmt1 -> close();

    echo $email;

} else {
    echo "Query Error (acct_info_email.php stmt1->prepare) : $stmt1->errno : $stmt1->error";
}

if ($stmt2 -> prepare("UPDATE `account_auths` SET user_email = ? WHERE account_auth_id = ?;")) {
    // Bind parameters
    $stmt2 -> bind_param("ss", $user_email, $_SESSION['account_auth_id']);

    // Execute query
    $stmt2 -> execute();

    // Close statement
    $stmt2 -> close();

} else {
    echo "Query Error (acct_info_email.php stmt2->prepare) : $stmt2->errno : $stmt2->error";
}

$conn -> close();

?>