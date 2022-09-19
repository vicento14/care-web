<?php

include('../database/config.php');

$result_array = array();
$result_array['dept_svc_array'] = array();
$result_array['success'] = 1;
$result_array['message'] = "";

$dept_id = ($conn -> real_escape_string($_POST['dept_id'])) ? $conn -> real_escape_string($_POST['dept_id']) : $result_array['success'] = 0;
$dept_svc_id = ($conn -> real_escape_string($_POST['dept_svc_id'])) ? $conn -> real_escape_string($_POST['dept_svc_id']) : $result_array['success'] = 0;
$dept_svc_set_id = "";
$dept_svc_category_name = "";
$dept_svc_subcategory_name = "";
$dept_svc_docu_need = "";
$dept_svc_sbs_procedure = "";
$dept_svc_rfsp = "";
$dept_svc_estimate_time_transact = "";
$dept_svc_fees = "";
$dept_svc_procedure_filing_complaints = "";
$dept_svc_array = array();

if ($result_array['success'] != 0) {

  // Create a prepared statement
  $stmt1 = $conn -> stmt_init();
  $stmt2 = $conn -> stmt_init();

  if ($stmt1 -> prepare(
  "SELECT dept_id, dept_svc_set_id
  FROM `department_information`
  WHERE dept_id = ?;")) {
    // Bind parameters
    $stmt1 -> bind_param("s", $dept_id);

    // Execute query
    $stmt1 -> execute();

    // Fetch values
    $result = $stmt1 -> get_result();
    while($row = $result -> fetch_assoc()){
      $dept_svc_set_id = $row['dept_svc_set_id'];
    }

    // Close statement
    $stmt1 -> close();
  } else {
    $result_array['success'] = 0;
    $result_array['message'] .= "Query Error (dept_mgt_svc_view.php stmt1->prepare) : $stmt1->errno : $stmt1->error";
  }

  if ($stmt2 -> prepare(
  "SELECT * FROM `department_services` 
  WHERE dept_svc_id = ? 
  AND dept_svc_set_id = ?;")) {
    // Bind parameters
    $stmt2 -> bind_param("ss", $dept_svc_id, $dept_svc_set_id);

    // Execute query
    $stmt2 -> execute();

    // Fetch values
    $result = $stmt2 -> get_result();
    $numRows = $result -> num_rows;
    if ($numRows > 0) {
      while($row = $result -> fetch_assoc()){
        $index['dept_svc_category_name'] = $row['dept_svc_category_name'];
        $index['dept_svc_subcategory_name'] = $row['dept_svc_subcategory_name'];
        $index['dept_svc_docu_need'] = $row['dept_svc_docu_need'];
        $index['dept_svc_sbs_procedure'] = $row['dept_svc_sbs_procedure'];
        $index['dept_svc_rfsp'] = $row['dept_svc_rfsp'];
        $index['dept_svc_estimate_time_transact'] = $row['dept_svc_estimate_time_transact'];
        $index['dept_svc_fees'] = $row['dept_svc_fees'];
        $index['dept_svc_procedure_filing_complaints'] = $row['dept_svc_procedure_filing_complaints'];
      }
      array_push($result_array['dept_svc_array'], $index);
      $result_array['success'] = 1;
      $result_array['message'] .= "Success";
    } else {
      $result_array['success'] = 0;
      $result_array['message'] .= "Not Found";
    }

    // Close statement
    $stmt2 -> close();

  } else {
    $result_array['success'] = 0;
    $result_array['message'] .= "Query Error (dept_mgt_svc_view.php stmt2->prepare) : $stmt2->errno : $stmt2->error";
  }

} else {
  $result_array['message'] .= "Please fill out the blank fields";
}

echo json_encode($result_array);

$conn -> close();

?>