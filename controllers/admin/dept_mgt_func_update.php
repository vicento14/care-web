<?php

//Update

include('../database/config.php');

session_start();

$dept_id = $_SESSION['dept_id'];
$dept_func_details = ($_POST['dept_func_details']) ? $_POST['dept_func_details'] : '';
$dept_func_id = "";
date_default_timezone_set("Asia/Manila");
$date_updated = date('Y-m-d H:i:s');

// Create a prepared statement
$stmt1 = $conn -> stmt_init();
$stmt2 = $conn -> stmt_init();

if ($stmt1 -> prepare("
SELECT *
FROM `department_information` 
WHERE dept_id = ?;")) {
  // Bind parameters
  $stmt1 -> bind_param("s", $dept_id);

  // Execute query
  $stmt1 -> execute();

  // Fetch values
  $result = $stmt1 -> get_result();
  while($row = $result -> fetch_assoc()){
    $dept_func_id = $row['dept_func_id'];
  }

  // Close statement
  $stmt1 -> close();
} else {
  echo "Query Error (dept_mgt_func_update.php stmt1->prepare) : $stmt1->errno : $stmt1->error";
}

if ($stmt2 -> prepare("
UPDATE `department_functions`
SET dept_func_details = ?, date_updated = ? 
WHERE dept_func_id = ?;")) {
  // Bind parameters
  $stmt2 -> bind_param("sss", $dept_func_details, $date_updated, $dept_func_id);

  // Execute query
  $stmt2 -> execute();

  // Close statement
  $stmt2 -> close();
} else {
  echo "Query Error (dept_mgt_func_update.php stmt2->prepare) : $stmt2->errno : $stmt2->error";
}

$conn -> close();

?>