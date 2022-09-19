<?php
include('../database/config.php');

session_start();

// Create a prepared statement
$stmt1 = $conn -> stmt_init();

if ($stmt1 -> prepare(
    "UPDATE `account_information` 
    SET active = 0 
    WHERE account_id = ?;")) {
    
    // Bind parameters
    $stmt1 -> bind_param("s", $_SESSION['account_id']);

    // Execute query
    $stmt1 -> execute();

    // Close statement
    $stmt1 -> close();

    session_destroy();
    header('location:https://careappsoftware.ml/admin/index.php');

} else {
    echo "Query Error (sign-out.php stmt1->prepare) : $stmt1->errno : $stmt1->error";
}

?>