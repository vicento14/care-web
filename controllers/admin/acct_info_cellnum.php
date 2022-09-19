<?php
include('../database/config.php');

session_start();

$cellphone_number = ($conn -> real_escape_string($_POST['cellphone_number'])) ? $conn -> real_escape_string($_POST['cellphone_number']) : '';

// Create a prepared statement
$stmt1 = $conn -> stmt_init();

if ($stmt1 -> prepare("UPDATE `account_information` SET cellphone_number = ? WHERE account_id = ?;")) {
    // Bind parameters
    $stmt1 -> bind_param("ss", $cellphone_number, $_SESSION['account_id']);

    // Execute query
    $stmt1 -> execute();

    $_SESSION['cellphone_number'] = $cellphone_number;

    // Close statement
    $stmt1 -> close();

    echo $cellphone_number;

} else {
    echo "Query Error (acct_info_name.php stmt1->prepare) : $stmt1->errno : $stmt1->error";
}

$conn -> close();

?>