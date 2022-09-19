<?php

//Delete

include('../database/config.php');

$dept_docu_id = ($conn -> real_escape_string($_POST['dept_docu_id'])) ? $conn -> real_escape_string($_POST['dept_docu_id']) : '';
$old_dept_docu_filename = "";
$uploadOk = 1;

// Create a prepared statement
$stmt1 = $conn -> stmt_init();
$stmt2 = $conn -> stmt_init();

if ($stmt1 -> prepare("
SELECT dept_docu_filename 
FROM `department_documents` 
WHERE dept_docu_id = ?;")) {
  // Bind parameters
  $stmt1 -> bind_param("s", $dept_docu_id);

  // Execute query
  $stmt1 -> execute();

  // Fetch values
  $result = $stmt1 -> get_result();
  $numRows = $result -> num_rows;
  if ($numRows != 0) {
    while($row = $result -> fetch_assoc()){
      $old_dept_docu_filename = $row['dept_docu_filename'];
    }
  } else {
    echo "The dept_docu_id not found. ";
    $uploadOk = 0;
  }

  // Close statement
  $stmt1 -> close();

} else {
  echo "Query Error (dept_mgt_docu_delete.php stmt1->prepare) : $stmt1->errno : $stmt1->error";
}

if ($uploadOk != 0) {
  //Delete Uploaded File
  $target_dir = "./uploads/documents/";
  $target_file = $target_dir . basename($old_dept_docu_filename);
  if (file_exists($target_file)) {
    if (!unlink($target_file)) { 
      echo ("The file called $old_dept_docu_filename cannot be deleted due to an error"); 
      $uploadOk = 0;
    }
  } else {
    echo "File doesn't exist. ";
    $uploadOk = 0;
  }
}

if ($uploadOk != 0) {
  if ($stmt2 -> prepare("DELETE FROM `department_documents` WHERE dept_docu_id = ?;")) {
    // Bind parameters
    $stmt2 -> bind_param("s", $dept_docu_id);
  
    // Execute query
    $stmt2 -> execute();
  
    // Close statement
    $stmt2 -> close();

    echo "Record Deleted Successfully. ";

  } else {
    echo "Query Error (dept_mgt_docu_delete.php stmt2->prepare) : $stmt2->errno : $stmt2->error";
  }
}

$conn -> close();

?>