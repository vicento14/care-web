<?php

//Insert

include('../database/config.php');

session_start();

$dept_id = $_SESSION['dept_id'];
$dept_svc_id = 0;
$dept_svc_category_name = ($_POST['dept_svc_category_name']) ? $_POST['dept_svc_category_name'] : '';
$dept_svc_subcategory_name = ($_POST['dept_svc_subcategory_name']) ? $_POST['dept_svc_subcategory_name'] : '';
$dept_svc_docu_need = ($_POST['dept_svc_docu_need']) ? $_POST['dept_svc_docu_need'] : '';
$dept_svc_sbs_procedure = ($_POST['dept_svc_sbs_procedure']) ? $_POST['dept_svc_sbs_procedure'] : '';
$dept_svc_rfsp = ($_POST['dept_svc_rfsp']) ? $_POST['dept_svc_rfsp'] : '';
$dept_svc_estimate_time_transact = ($_POST['dept_svc_estimate_time_transact']) ? $_POST['dept_svc_estimate_time_transact'] : '';
$dept_svc_fees = ($_POST['dept_svc_fees']) ? $_POST['dept_svc_fees'] : '';
$dept_svc_procedure_filing_complaints = ($_POST['dept_svc_procedure_filing_complaints']) ? $_POST['dept_svc_procedure_filing_complaints'] : '';
$dept_svc_set_id = "";

// Create a prepared statement
$stmt1 = $conn -> stmt_init();
$stmt2 = $conn -> stmt_init();
$stmt3 = $conn -> stmt_init();

if ($stmt1 -> prepare("SELECT dept_svc_id FROM `department_services` ORDER BY dept_svc_id DESC LIMIT 1;")) {
  // Execute query
  $stmt1 -> execute();

  // Fetch values
  $result = $stmt1 -> get_result();
  $numRows = $result -> num_rows;
  if ($numRows > 0) {
    while($row = $result -> fetch_assoc()){
      $dept_svc_id = intval($row['dept_svc_id']);
    }
  }

  // Close statement
  $stmt1 -> close();

  $dept_svc_id++;

} else {
  echo "Query Error (dept_mgt_svc_insert.php stmt1->prepare) : $stmt1->errno : $stmt1->error";
}

if ($stmt2 -> prepare("
SELECT dept_id, dept_svc_set_id
FROM `department_information`
WHERE dept_id = ?;")) {
  // Bind parameters
  $stmt2 -> bind_param("s", $dept_id);

  // Execute query
  $stmt2 -> execute();

  // Fetch values
  $result = $stmt2 -> get_result();
  while($row = $result -> fetch_assoc()){
    $dept_svc_set_id = $row['dept_svc_set_id'];
  }

  // Close statement
  $stmt2 -> close();
} else {
  echo "Query Error (dept_mgt_svc_insert.php stmt2->prepare) : $stmt2->errno : $stmt2->error";
}

if ($stmt3 -> prepare("
INSERT INTO `department_services` 
(dept_svc_id, dept_svc_set_id, 
dept_svc_category_name, dept_svc_subcategory_name, 
dept_svc_docu_need, dept_svc_sbs_procedure, 
dept_svc_rfsp, dept_svc_estimate_time_transact, 
dept_svc_fees, dept_svc_procedure_filing_complaints)
VALUES (?, ?, ?, ?, ?, ?, ?, ?, ?, ?);")) {
  // Bind parameters
  $stmt3 -> bind_param("ssssssssss", $dept_svc_id, $dept_svc_set_id, 
  $dept_svc_category_name, $dept_svc_subcategory_name,
  $dept_svc_docu_need, $dept_svc_sbs_procedure,
  $dept_svc_rfsp, $dept_svc_estimate_time_transact, 
  $dept_svc_fees, $dept_svc_procedure_filing_complaints);

  // Execute query
  $stmt3 -> execute();

  // Close statement
  $stmt3 -> close();
} else {
  echo "Query Error (dept_mgt_svc_insert.php stmt3->prepare) : $stmt3->errno : $stmt3->error";
}

$conn -> close();

?>