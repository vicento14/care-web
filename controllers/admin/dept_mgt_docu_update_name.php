<?php
include('../database/config.php');

session_start();

$dept_id = $_SESSION['dept_id'];

$dept_docu_id = $conn -> real_escape_string($_POST['dept_docu_id']);
$dept_docu_name = ($_POST['dept_docu_name']) ? $_POST['dept_docu_name'] : '';

// Create a prepared statement
$stmt1 = $conn -> stmt_init();

if ($stmt1 -> prepare("
UPDATE `department_documents`
SET dept_docu_name = ? 
WHERE dept_docu_id = ?;")) {
    // Bind parameters
    $stmt1 -> bind_param("ss", $dept_docu_name, $dept_docu_id);

    // Execute query
    $stmt1 -> execute();

    // Close statement
    $stmt1 -> close();

    echo "Record Saved Successfully. ";

} else {
    echo "Query Error (dept_mgt_docu_update_name.php stmt1->prepare) : $stmt1->errno : $stmt1->error";
}
?>