<?php

include('../database/config.php');

$result_array = array();
$result_array['dept_func_array'] = array();
$result_array['success'] = 1;
$result_array['message'] = "";

$dept_id = ($conn -> real_escape_string($_POST['dept_id'])) ? $conn -> real_escape_string($_POST['dept_id']) : $result_array['success'] = 0;
$dept_func_id = "";
$dept_func_details = "";
$date_updated = 0;                                

if ($result_array['success'] != 0) {

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
    $result_array['success'] = 0;
    $result_array['message'] .= "Query Error (dept_mgt_func_load.php stmt1->prepare) : $stmt1->errno : $stmt1->error";
  }

  if ($stmt2 -> prepare("
  SELECT * 
  FROM `department_functions` 
  WHERE dept_func_id = ?;")) {
    // Bind parameters
    $stmt2 -> bind_param("s", $dept_func_id);

    // Execute query
    $stmt2 -> execute();

    // Fetch values
    $result = $stmt2 -> get_result();
    $numRows = $result -> num_rows;
    if ($numRows > 0) {
      while($row = $result -> fetch_assoc()){
        $index['dept_func_details'] = $row['dept_func_details'];
        $index['date_updated'] = date("Y-m-d h:iA", strtotime($row['date_updated']));
      }
      array_push($result_array['dept_func_array'], $index);
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
    $result_array['message'] .= "Query Error (dept_mgt_func_load.php stmt2->prepare) : $stmt2->errno : $stmt2->error";
  }

} else {
  $result_array['message'] .= "Please fill out the blank fields";
}

echo json_encode($result_array);

$conn->close();

?>