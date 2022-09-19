<?php

//Upload -- Insert or Update

include('../database/config.php');

session_start();

$dept_id = $_SESSION['dept_id'];

$dept_docu_data = $_FILES['dept_docu_data']['tmp_name'];
$dept_docu_filename = $_FILES['dept_docu_data']['name'];
$dept_docu_filetype = $_FILES['dept_docu_data']['type'];
$old_dept_docu_filename = "";
$dept_docu_url = "https://careappsoftware.ml/controllers/admin/uploads/documents/";

$dept_docu_id = $conn -> real_escape_string($_POST['dept_docu_id']);
$dept_docu_name = $_POST['dept_docu_name'];
$is_insert = $conn -> real_escape_string($_POST['is_insert']);
$dept_docu_set_id = 0;

//Upload File
$target_dir = "./uploads/documents/";
$target_file = $target_dir . basename($dept_docu_filename);
$dept_docu_url .= rawurlencode(basename($dept_docu_filename));
$uploadOk = 1;

// Create a prepared statement
$stmt1 = $conn -> stmt_init();
$stmt2 = $conn -> stmt_init();
$stmt3 = $conn -> stmt_init();
$stmt4 = $conn -> stmt_init();
$stmt5 = $conn -> stmt_init();
$stmt6 = $conn -> stmt_init();
$stmt7 = $conn -> stmt_init();

if (file_exists($target_file)) {
  if ($is_insert == 1) {
    echo "Sorry, file already exists. ";
    $uploadOk = 0;
  } else {
    if ($stmt1 -> prepare("
    SELECT dept_docu_filename 
    FROM `department_documents` 
    WHERE dept_docu_filename = ?;")) {
      // Bind parameters
      $stmt1 -> bind_param("s", $dept_docu_filename);

      // Execute query
      $stmt1 -> execute();

      // Fetch values
      $result = $stmt1 -> get_result();
      $numRows = $result -> num_rows;

      if ($stmt2 -> prepare("
      SELECT dept_docu_filename 
      FROM `department_documents` 
      WHERE dept_docu_id = ?;")) {
        // Bind parameters
        $stmt2 -> bind_param("s", $dept_docu_id);

        // Execute query
        $stmt2 -> execute();

        // Fetch values
        $result = $stmt2 -> get_result();
        while($row = $result -> fetch_assoc()){
          $old_dept_docu_filename = $row['dept_docu_filename'];
        }

        // Close statement
        $stmt2 -> close();

      } else {
        echo "Query Error (dept_mgt_docu_upload.php stmt2->prepare) : $stmt2->errno : $stmt2->error";
      }
      $old_target_file = $target_dir . basename($old_dept_docu_filename);

      if ($numRows != 0) {
        if ($old_dept_docu_filename == $dept_docu_filename) {
          if (!unlink($target_file)) { 
            echo ("The file called $dept_docu_filename cannot be replaced due to an error"); 
            $uploadOk = 0;
          }
        } else {
          echo "Sorry, file already exists. ";
          $uploadOk = 0;
        }
      }

      // Close statement
      $stmt1 -> close();

    } else {
      echo "Query Error (dept_mgt_docu_upload.php stmt1->prepare) : $stmt1->errno : $stmt1->error";
    }
  }
} else if ($is_insert == 0) {
  if ($stmt3 -> prepare("
  SELECT dept_docu_filename 
  FROM `department_documents` 
  WHERE dept_docu_id = ?;")) {
    // Bind parameters
    $stmt3 -> bind_param("s", $dept_docu_id);

    // Execute query
    $stmt3 -> execute();

    // Fetch values
    $result = $stmt3 -> get_result();
    while($row = $result -> fetch_assoc()){
      $old_dept_docu_filename = $row['dept_docu_filename'];
    }

    // Close statement
    $stmt3 -> close();

  } else {
    echo "Query Error (dept_mgt_docu_upload.php stmt3->prepare) : $stmt3->errno : $stmt3->error";
  }
  $old_target_file = $target_dir . basename($old_dept_docu_filename);
  if (file_exists($old_target_file)) {
    if (!unlink($old_target_file)) { 
      echo ("The file called $old_dept_docu_filename cannot be replaced due to an error"); 
      $uploadOk = 0;
    }
  }
}

// Check file size
if ($_FILES["dept_docu_data"]["size"] > 25000000) {
  echo "Sorry, your file is too large. ";
  $uploadOk = 0;
}

// Check if $uploadOk is set to 0 by an error
if ($uploadOk == 0) {
  echo "Sorry, your file was not uploaded. ";
// if everything is ok, try to upload file
} else {
  if (move_uploaded_file($dept_docu_data, $target_file)) {
    echo "The file " . htmlspecialchars(basename($dept_docu_filename)) . " has been uploaded. ";
  } else {
    echo "Sorry, there was an error uploading your file. ";
    $uploadOk = 0;
  }
}

if ($uploadOk != 0) {
  if ($is_insert == 1) {
    if ($stmt4 -> prepare("SELECT dept_docu_id FROM `department_documents` ORDER BY dept_docu_id DESC LIMIT 1;")) {
      // Execute query
      $stmt4 -> execute();
    
      // Fetch values
      $result = $stmt4 -> get_result();
      $numRows = $result -> num_rows;
      if ($numRows > 0) {
        while($row = $result -> fetch_assoc()){
          $dept_docu_id = intval($row['dept_docu_id']);
        }
      }
    
      // Close statement
      $stmt4 -> close();
    
      $dept_docu_id++;
    
    } else {
      echo "Query Error (dept_mgt_docu_upload.php stmt4->prepare) : $stmt4->errno : $stmt4->error";
    }
    if ($stmt5 -> prepare("
    SELECT dept_id, dept_docu_set_id
    FROM `department_information`
    WHERE dept_id = ?;")) {
      // Bind parameters
      $stmt5 -> bind_param("s", $dept_id);
  
      // Execute query
      $stmt5 -> execute();
  
      // Fetch values
      $result = $stmt5 -> get_result();
      while($row = $result -> fetch_assoc()){
        $dept_docu_set_id = intval($row['dept_docu_set_id']);
      }
  
      // Close statement
      $stmt5 -> close();
    } else {
      echo "Query Error (dept_mgt_docu_upload.php stmt5->prepare) : $stmt5->errno : $stmt5->error";
    }
    if ($stmt6 -> prepare("
    INSERT INTO `department_documents` 
    (dept_docu_id, dept_docu_set_id, 
    dept_docu_name, dept_docu_filename, 
    dept_docu_filetype, dept_docu_url)
    VALUES (?, ?, ?, ?, ?, ?);")) {
      // Bind parameters
      $stmt6 -> bind_param("ssssss", $dept_docu_id, $dept_docu_set_id, $dept_docu_name, $dept_docu_filename, $dept_docu_filetype, $dept_docu_url);
  
      // Execute query
      $stmt6 -> execute();
  
      // Close statement
      $stmt6 -> close();

      echo "Record Added Successfully. ";
  
    } else {
      echo "Query Error (dept_mgt_docu_upload.php stmt6->prepare) : $stmt6->errno : $stmt6->error";
    }
  } else {
    if ($stmt7 -> prepare("
    UPDATE `department_documents`
    SET dept_docu_name = ?, 
    dept_docu_filename = ?, 
    dept_docu_filetype = ?, 
    dept_docu_url = ?
    WHERE dept_docu_id = ?;")) {
      // Bind parameters
      $stmt7 -> bind_param("sssss", $dept_docu_name, $dept_docu_filename, $dept_docu_filetype, $dept_docu_url, $dept_docu_id);
  
      // Execute query
      $stmt7 -> execute();
  
      // Close statement
      $stmt7 -> close();

      echo "Record Saved Successfully. ";
  
    } else {
      echo "Query Error (dept_mgt_docu_upload.php stmt7->prepare) : $stmt7->errno : $stmt7->error";
    }
  }
}

$conn -> close();

?>