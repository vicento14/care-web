<?php

//View

include('../database/config.php');

$dept_svc_id = ($conn -> real_escape_string($_POST['dept_svc_id'])) ? $conn -> real_escape_string($_POST['dept_svc_id']) : '';
$dept_svc_category_name = "";
$dept_svc_subcategory_name = "";
$dept_svc_docu_need = "";
$dept_svc_sbs_procedure = "";
$dept_svc_rfsp = "";
$dept_svc_estimate_time_transact = "";
$dept_svc_fees = "";
$dept_svc_procedure_filing_complaints = "";
$dept_svc_array = array();

// Create a prepared statement
$stmt1 = $conn -> stmt_init();

if ($stmt1 -> prepare("SELECT * FROM `department_services` WHERE dept_svc_id = ?;")) {
  // Bind parameters
  $stmt1 -> bind_param("s", $dept_svc_id);

  // Execute query
  $stmt1 -> execute();

  // Fetch values
  $result = $stmt1 -> get_result();
  while($row = $result -> fetch_assoc()){
    $dept_svc_category_name = $row['dept_svc_category_name'];
    $dept_svc_subcategory_name = $row['dept_svc_subcategory_name'];
    $dept_svc_docu_need = $row['dept_svc_docu_need'];
    $dept_svc_sbs_procedure = $row['dept_svc_sbs_procedure'];
    $dept_svc_rfsp = $row['dept_svc_rfsp'];
    $dept_svc_estimate_time_transact = $row['dept_svc_estimate_time_transact'];
    $dept_svc_fees = $row['dept_svc_fees'];
    $dept_svc_procedure_filing_complaints = $row['dept_svc_procedure_filing_complaints'];
    $dept_svc_array = array(
      'dept_svc_category_name' => $dept_svc_category_name, 
      'dept_svc_subcategory_name' => $dept_svc_subcategory_name, 
      'dept_svc_docu_need' => $dept_svc_docu_need, 
      'dept_svc_sbs_procedure' => $dept_svc_sbs_procedure, 
      'dept_svc_rfsp' => $dept_svc_rfsp,
      'dept_svc_estimate_time_transact' => $dept_svc_estimate_time_transact, 
      'dept_svc_fees' => $dept_svc_fees, 
      'dept_svc_procedure_filing_complaints' => $dept_svc_procedure_filing_complaints);
  }

  // Close statement
  $stmt1 -> close();

  echo json_encode($dept_svc_array, JSON_FORCE_OBJECT);

} else {
  echo "Query Error (dept_mgt_svc_view.php stmt1->prepare) : $stmt1->errno : $stmt1->error";
}

$conn -> close();

?>