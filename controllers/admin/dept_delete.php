<?php

//Delete

include('../database/config.php');

$dept_id = ($conn -> real_escape_string($_POST['dept_id'])) ? $conn -> real_escape_string($_POST['dept_id']) : '';
$dept_func_id = "";
$dept_imprtnc_id = "";
$dept_svc_set_id = "";
$dept_docu_set_id = "";
$old_dept_docu_filenames_array = array();
$uploadOk = 1;
$uploadOk2 = 1;

// Create a prepared statement
$stmt1 = $conn -> stmt_init();
$stmt2 = $conn -> stmt_init();
$stmt3 = $conn -> stmt_init();
$stmt4 = $conn -> stmt_init();
$stmt5 = $conn -> stmt_init();
$stmt6 = $conn -> stmt_init();
$stmt7 = $conn -> stmt_init();
$stmt8 = $conn -> stmt_init();
$stmt9 = $conn -> stmt_init();
$stmt10 = $conn -> stmt_init();

if ($stmt1 -> prepare("SELECT * FROM `department_information` WHERE dept_id = ?;")) {
  
  // Bind parameters
  $stmt1 -> bind_param("s", $dept_id);

  // Execute query
  $stmt1 -> execute();
  
  // Fetch values
  $result = $stmt1 -> get_result();
  while($row = $result -> fetch_assoc()){
    $dept_func_id = $row['dept_func_id'];
    $dept_imprtnc_id = $row['dept_imprtnc_id'];
    $dept_svc_set_id = $row['dept_svc_set_id'];
    $dept_docu_set_id = $row['dept_docu_set_id'];
  }

  // Close statement
  $stmt1 -> close();

} else {
  echo "Query Error (dept_delete.php stmt1->prepare) : $stmt1->errno : $stmt1->error";
}

if ($stmt2 -> prepare("SELECT * FROM `admins_departments` WHERE dept_id = ?;")) {
  
  // Bind parameters
  $stmt2 -> bind_param("s", $dept_id);

  // Execute query
  $stmt2 -> execute();
  
  // Fetch values
  $result = $stmt2 -> get_result();
  $numRows = $result -> num_rows;
  if ($numRows != 0) {
    $uploadOk = 0;
  }

  // Close statement
  $stmt2 -> close();

} else {
  echo "Query Error (dept_delete.php stmt2->prepare) : $stmt2->errno : $stmt2->error";
}

if ($stmt3 -> prepare("SELECT * FROM `assistance_transactions` WHERE dept_id = ?;")) {
  
  // Bind parameters
  $stmt3 -> bind_param("s", $dept_id);

  // Execute query
  $stmt3 -> execute();
  
  // Fetch values
  $result = $stmt3 -> get_result();
  $numRows = $result -> num_rows;
  if ($numRows != 0) {
    $uploadOk = 0;
  }

  // Close statement
  $stmt3 -> close();

} else {
  echo "Query Error (dept_delete.php stmt3->prepare) : $stmt3->errno : $stmt3->error";
}

if ($uploadOk != 0) {
  if ($stmt4 -> prepare("
  SELECT dept_docu_filename 
  FROM `department_documents` 
  WHERE dept_docu_set_id = ?;")) {
    // Bind parameters
    $stmt4 -> bind_param("s", $dept_docu_set_id);

    // Execute query
    $stmt4 -> execute();

    // Fetch values
    $result = $stmt4 -> get_result();
    $numRows = $result -> num_rows;
    if ($numRows != 0) {
      while($row = $result -> fetch_assoc()){
        $index['old_dept_docu_filename'] = $row['dept_docu_filename'];
        array_push($old_dept_docu_filenames_array, $index);
      }
      //Delete Uploaded File
      $target_dir = "./uploads/documents/";
      foreach ($old_dept_docu_filenames_array as $old_dept_docu_filename) {
        $target_file = $target_dir . basename($old_dept_docu_filename);
        if (file_exists($target_file)) {
          if (!unlink($target_file)) { 
            echo (" The file called $old_dept_docu_filename cannot be deleted due to web server or network error"); 
            $uploadOk = 0;
            $uploadOk2 = 0;
          }
        } else {
          echo " The file called $old_dept_docu_filename is missing for unknown reason. Contact Developer";
          $uploadOk = 0;
          $uploadOk2 = 0;
        }
      }
    }

    // Close statement
    $stmt4 -> close();

  } else {
    echo "Query Error (dept_delete.php stmt2->prepare) : $stmt4->errno : $stmt4->error";
  }
} else {
  echo "The department selected cannot be deleted. There was an existing department admins or reports that belongs to this department";
}

if ($uploadOk != 0) {
  if ($stmt5 -> prepare("DELETE FROM `department_documents` WHERE dept_docu_set_id = ?;")) {
    // Bind parameters
    $stmt5 -> bind_param("s", $dept_docu_set_id);
  
    // Execute query
    $stmt5 -> execute();
  
    // Close statement
    $stmt5 -> close();
  } else {
    echo "Query Error (dept_delete.php stmt5->prepare) : $stmt5->errno : $stmt5->error";
  }
  
  if ($stmt6 -> prepare("DELETE FROM `department_services` WHERE dept_svc_set_id = ?;")) {
    // Bind parameters
    $stmt6 -> bind_param("s", $dept_svc_set_id);
  
    // Execute query
    $stmt6 -> execute();
  
    // Close statement
    $stmt6 -> close();
  } else {
    echo "Query Error (dept_delete.php stmt6->prepare) : $stmt6->errno : $stmt6->error";
  }
  
  if ($stmt7 -> prepare("DELETE FROM `department_information` WHERE dept_id = ?;")) {
    // Bind parameters
    $stmt7 -> bind_param("s", $dept_id);
  
    // Execute query
    $stmt7 -> execute();
  
    // Close statement
    $stmt7 -> close();
  } else {
    echo "Query Error (dept_delete.php stmt7->prepare) : $stmt7->errno : $stmt7->error";
  }
  
  if ($stmt8 -> prepare("DELETE FROM `department_importance` WHERE dept_imprtnc_id = ?;")) {
    // Bind parameters
    $stmt8 -> bind_param("s", $dept_imprtnc_id);
  
    // Execute query
    $stmt8 -> execute();
  
    // Close statement
    $stmt8 -> close();
  } else {
    echo "Query Error (dept_delete.php stmt8->prepare) : $stmt8->errno : $stmt8->error";
  }
  
  if ($stmt9 -> prepare("DELETE FROM `department_functions` WHERE dept_func_id = ?;")) {
    // Bind parameters
    $stmt9 -> bind_param("s", $dept_func_id);
  
    // Execute query
    $stmt9 -> execute();
  
    // Close statement
    $stmt9 -> close();
  } else {
    echo "Query Error (dept_delete.php stmt9->prepare) : $stmt9->errno : $stmt9->error";
  }
  
  if ($stmt10 -> prepare("DELETE FROM `departments` WHERE dept_id = ?;")) {
    // Bind parameters
    $stmt10 -> bind_param("s", $dept_id);
  
    // Execute query
    $stmt10 -> execute();
  
    // Close statement
    $stmt10 -> close();
  } else {
    echo "Query Error (dept_delete.php stmt10->prepare) : $stmt10->errno : $stmt10->error";
  }
} else if ($uploadOk2 == 0) {
  echo "The department selected cannot be deleted. There was an error when deleting all existing department documents";
}

if ($uploadOk != 0) {
  echo "Department Record Deleted Successfully";
}

$conn -> close();

?>