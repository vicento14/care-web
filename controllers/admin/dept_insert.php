<?php

//Insert

include('../database/config.php');

$dept_name = ($_POST['dept_name']) ? $_POST['dept_name'] : '';
$dept_id = 0;
$dept_func_id = $dept_id;
$dept_imprtnc_id = $dept_id;
$dept_svc_set_id = $dept_id;
$dept_docu_set_id = $dept_id;

// Create a prepared statement
$stmt1 = $conn -> stmt_init();
$stmt2 = $conn -> stmt_init();
$stmt3 = $conn -> stmt_init();
$stmt4 = $conn -> stmt_init();
$stmt5 = $conn -> stmt_init();

if ($stmt1 -> prepare("SELECT dept_id FROM `departments` ORDER BY dept_id DESC LIMIT 1;")) {
  // Execute query
  $stmt1 -> execute();

  // Fetch values
  $result = $stmt1 -> get_result();
  $numRows = $result -> num_rows;
  if ($numRows > 0) {
    while($row = $result -> fetch_assoc()){
      $dept_id = intval($row['dept_id']);
    }
  }

  // Close statement
  $stmt1 -> close();

  $dept_id++;
  $dept_func_id = $dept_id;
  $dept_imprtnc_id = $dept_id;
  $dept_svc_set_id = $dept_id;
  $dept_docu_set_id = $dept_id;

} else {
  echo "Query Error (dept_insert.php stmt1->prepare) : $stmt1->errno : $stmt1->error";
}

if ($stmt2 -> prepare("
INSERT INTO `departments` (dept_id, dept_name)
VALUES (?, ?);")) {
  // Bind parameters
  $stmt2 -> bind_param("ss", $dept_id, $dept_name);

  // Execute query
  $stmt2 -> execute();

  // Close statement
  $stmt2 -> close();
} else {
  echo "Query Error (dept_insert.php stmt2->prepare) : $stmt2->errno : $stmt2->error";
}

if ($stmt3 -> prepare("
INSERT INTO `department_functions` (dept_func_id, dept_func_details)
VALUES (?, '');")) {
  // Bind parameters
  $stmt3 -> bind_param("s", $dept_func_id);

  // Execute query
  $stmt3 -> execute();

  // Close statement
  $stmt3 -> close();
} else {
  echo "Query Error (dept_insert.php stmt3->prepare) : $stmt3->errno : $stmt3->error";
}

if ($stmt4 -> prepare("
INSERT INTO `department_importance` (dept_imprtnc_id, dept_imprtnc_details)
VALUES (?, '');")) {
  // Bind parameters
  $stmt4 -> bind_param("s", $dept_imprtnc_id);

  // Execute query
  $stmt4 -> execute();

  // Close statement
  $stmt4 -> close();
} else {
  echo "Query Error (dept_insert.php stmt4->prepare) : $stmt4->errno : $stmt4->error";
}

if ($stmt5 -> prepare("
INSERT INTO `department_information` (dept_id, dept_func_id, dept_imprtnc_id, dept_svc_set_id, dept_docu_set_id)
VALUES (?, ?, ?, ?, ?);")) {
  // Bind parameters
  $stmt5 -> bind_param("sssss", $dept_id, $dept_func_id, $dept_imprtnc_id, $dept_svc_set_id, $dept_docu_set_id);

  // Execute query
  $stmt5 -> execute();

  // Close statement
  $stmt5 -> close();
} else {
  echo "Query Error (dept_insert.php stmt5->prepare) : $stmt5->errno : $stmt5->error";
}

$conn -> close();

?>