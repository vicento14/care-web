<?php
include('../database/config.php');

session_start();

$account_name = ($_POST['account_name']) ? $_POST['account_name'] : '';
$admin_id = $_SESSION['admin_id'];
$admin_name = $account_name;

// Create a prepared statement
$stmt1 = $conn -> stmt_init();
$stmt2 = $conn -> stmt_init();

if ($admin_id != "") {
    if ($stmt1 -> prepare("UPDATE `accounts` SET account_name = ? WHERE account_id = ?;")) {
        // Bind parameters
        $stmt1 -> bind_param("ss", $account_name, $_SESSION['account_id']);
    
        // Execute query
        $stmt1 -> execute();
    
        $_SESSION['account_name'] = $account_name;
    
        // Close statement
        $stmt1 -> close();
    
    } else {
        echo "Query Error (acct_info_name.php stmt1->prepare) : $stmt1->errno : $stmt1->error";
    }
    
    if ($stmt2 -> prepare("
    UPDATE `admins` 
    SET admin_name = ? 
    WHERE admin_id = ?;")) {
        // Bind parameters
        $stmt2 -> bind_param("ss", $admin_name, $admin_id);
    
        // Execute query
        $stmt2 -> execute();
    
        // Close statement
        $stmt2 -> close();

        echo $_SESSION['account_name'];
    
    } else {
        echo "Query Error (acct_info_name.php stmt2->prepare) : $stmt2->errno : $stmt2->error";
    }
}

$conn -> close();

?>