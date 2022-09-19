<?php

//Update

include('../database/config.php');

$dept_svc_id = ($conn -> real_escape_string($_POST['dept_svc_id'])) ? $conn -> real_escape_string($_POST['dept_svc_id']) : '';
$dept_svc_category_name = ($_POST['dept_svc_category_name']) ? $_POST['dept_svc_category_name'] : '';
$dept_svc_subcategory_name = ($_POST['dept_svc_subcategory_name']) ? $_POST['dept_svc_subcategory_name'] : '';
$dept_svc_docu_need = ($_POST['dept_svc_docu_need']) ? $_POST['dept_svc_docu_need'] : '';
$dept_svc_sbs_procedure = ($_POST['dept_svc_sbs_procedure']) ? $_POST['dept_svc_sbs_procedure'] : '';
$dept_svc_rfsp = ($_POST['dept_svc_rfsp']) ? $_POST['dept_svc_rfsp'] : '';
$dept_svc_estimate_time_transact = ($_POST['dept_svc_estimate_time_transact']) ? $_POST['dept_svc_estimate_time_transact'] : '';
$dept_svc_fees = ($_POST['dept_svc_fees']) ? $_POST['dept_svc_fees'] : '';
$dept_svc_procedure_filing_complaints = ($_POST['dept_svc_procedure_filing_complaints']) ? $_POST['dept_svc_procedure_filing_complaints'] : '';

// Create a prepared statement
$stmt1 = $conn -> stmt_init();

if ($stmt1 -> prepare("
UPDATE `department_services`
SET dept_svc_category_name = ?, 
dept_svc_subcategory_name = ?, 
dept_svc_docu_need = ?, 
dept_svc_sbs_procedure = ?, 
dept_svc_rfsp = ?, 
dept_svc_estimate_time_transact = ?, 
dept_svc_fees = ?, 
dept_svc_procedure_filing_complaints = ?  
WHERE dept_svc_id = ?;")) {
  // Bind parameters
  $stmt1 -> bind_param("sssssssss", $dept_svc_category_name, $dept_svc_subcategory_name,
  $dept_svc_docu_need, $dept_svc_sbs_procedure,
  $dept_svc_rfsp, $dept_svc_estimate_time_transact, 
  $dept_svc_fees, $dept_svc_procedure_filing_complaints, $dept_svc_id);

  // Execute query
  $stmt1 -> execute();

  // Close statement
  $stmt1 -> close();
} else {
  echo "Query Error (dept_mgt_svc_update.php stmt1->prepare) : $stmt1->errno : $stmt1->error";
}

$conn -> close();

?>