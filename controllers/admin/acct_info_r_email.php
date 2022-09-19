<?php
include('../database/config.php');

session_start();

$r_email = ($conn -> real_escape_string($_POST['r_email'])) ? $conn -> real_escape_string($_POST['r_email']) : '';

// Create a prepared statement
$stmt1 = $conn -> stmt_init();

if ($stmt1 -> prepare("
UPDATE `account_information`
SET r_email = ? 
WHERE account_id = ?;")) {
    // Bind parameters
    $stmt1 -> bind_param("ss", $r_email, $_SESSION['account_id']);

    // Execute query
    $stmt1 -> execute();

    $_SESSION['r_email'] = $r_email;

    // Close statement
    $stmt1 -> close();

    echo $r_email;

} else {
    echo "Query Error (acct_info_name.php stmt1->prepare) : $stmt1->errno : $stmt1->error";
}

$conn -> close();

?>