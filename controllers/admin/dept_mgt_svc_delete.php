<?php

//Delete

include('../database/config.php');

$dept_svc_id = ($conn -> real_escape_string($_POST['dept_svc_id'])) ? $conn -> real_escape_string($_POST['dept_svc_id']) : '';

// Create a prepared statement
$stmt1 = $conn -> stmt_init();

if ($stmt1 -> prepare("DELETE FROM `department_services` WHERE dept_svc_id = ?;")) {
  // Bind parameters
  $stmt1 -> bind_param("s", $dept_svc_id);

  // Execute query
  $stmt1 -> execute();

  // Close statement
  $stmt1 -> close();
} else {
  echo "Query Error (dept_mgt_svc_delete.php stmt1->prepare) : $stmt1->errno : $stmt1->error";
}

$conn -> close();

?>