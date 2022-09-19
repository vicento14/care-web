<?php

include('../database/config.php');

session_start();

$dept_id = $_SESSION['dept_id'];
$dept_imprtnc_id = "";
$dept_imprtnc_details = "";
$date_updated = 0;
$dept_imprtnc_array = array();

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
    $dept_imprtnc_id = $row['dept_imprtnc_id'];
  }

  // Close statement
  $stmt1 -> close();
} else {
  echo "Query Error (dept_mgt_imprtnc_load.php stmt1->prepare) : $stmt1->errno : $stmt1->error";
}

if ($stmt2 -> prepare("
SELECT * 
FROM `department_importance` 
WHERE dept_imprtnc_id = ?;")) {
  // Bind parameters
  $stmt2 -> bind_param("s", $dept_imprtnc_id);

  // Execute query
  $stmt2 -> execute();

  // Fetch values
  $result = $stmt2 -> get_result();
  while($row = $result -> fetch_assoc()){
    $dept_imprtnc_details = $row['dept_imprtnc_details'];
    $date_updated = date("Y-m-d h:iA", strtotime($row['date_updated']));
  }

  $dept_imprtnc_array = array(
    'dept_imprtnc_details' => $dept_imprtnc_details, 
    'date_updated' => $date_updated
  );

  // Close statement
  $stmt2 -> close();

  echo json_encode($dept_imprtnc_array, JSON_FORCE_OBJECT);

} else {
  echo "Query Error (dept_mgt_imprtnc_load.php stmt2->prepare) : $stmt2->errno : $stmt2->error";
}

$conn->close();

?>