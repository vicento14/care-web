<?php

//Update

include('../database/config.php');

$dept_id = ($conn -> real_escape_string($_POST['dept_id'])) ? $conn -> real_escape_string($_POST['dept_id']) : '';
$dept_name = ($_POST['dept_name']) ? $_POST['dept_name'] : '';

// Create a prepared statement
$stmt1 = $conn -> stmt_init();

if ($stmt1 -> prepare("
    UPDATE `departments`
    SET dept_name = ? 
    WHERE dept_id = ?;")) {

  // Bind parameters
  $stmt1 -> bind_param("ss", $dept_name, $dept_id);

  // Execute query
  $stmt1 -> execute();

  // Close statement
  $stmt1 -> close();

} else {
  echo "Query Error (dept_update.php stmt1->prepare) : $stmt1->errno : $stmt1->error";
}

$conn -> close();

?>