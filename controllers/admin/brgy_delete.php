<?php

//Delete

include('../database/config.php');

$barangay_id = ($conn -> real_escape_string($_POST['barangay_id'])) ? $conn -> real_escape_string($_POST['barangay_id']) : '';
$isOk = 1;

// Create a prepared statement
$stmt1 = $conn -> stmt_init();
$stmt2 = $conn -> stmt_init();
$stmt3 = $conn -> stmt_init();

if ($stmt1 -> prepare("SELECT * FROM `account_information` WHERE barangay_id = ?;")) {
  // Bind parameters
  $stmt1 -> bind_param("s", $barangay_id);

  // Execute query
  $stmt1 -> execute();
  
  // Fetch values
  $result = $stmt1 -> get_result();
  $numRows = $result -> num_rows;
  if ($numRows != 0) {
    $isOk = 0;
  }

  // Close statement
  $stmt1 -> close();
} else {
  echo "Query Error (brgy_delete.php stmt1->prepare) : $stmt1->errno : $stmt1->error";
}

if ($stmt2 -> prepare("SELECT * FROM `assistance_transactions` WHERE barangay_id = ?;")) {
  // Bind parameters
  $stmt2 -> bind_param("s", $barangay_id);

  // Execute query
  $stmt2 -> execute();
  
  // Fetch values
  $result = $stmt2 -> get_result();
  $numRows = $result -> num_rows;
  if ($numRows != 0) {
    $isOk = 0;
  }

  // Close statement
  $stmt2 -> close();
} else {
  echo "Query Error (brgy_delete.php stmt2->prepare) : $stmt2->errno : $stmt2->error";
}

if ($isOk != 0) {
  if ($stmt3 -> prepare("DELETE FROM `barangays` WHERE barangay_id = ?;")) {
    // Bind parameters
    $stmt3 -> bind_param("s", $barangay_id);
  
    // Execute query
    $stmt3 -> execute();
  
    // Close statement
    $stmt3 -> close();
  } else {
    echo "Query Error (brgy_delete.php stmt3->prepare) : $stmt3->errno : $stmt3->error";
    $isOk = 0;
  }
} else {
  echo "The barangay selected cannot be deleted. There was an existing residents or reports that belongs to this barangay";
}

if ($isOk != 0) {
  echo "Barangay Record Deleted Successfully";
}

$conn -> close();

?>