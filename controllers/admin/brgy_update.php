<?php

//Update

include('../database/config.php');

$barangay_id = ($conn -> real_escape_string($_POST['barangay_id'])) ? $conn -> real_escape_string($_POST['barangay_id']) : '';
$barangay_name = ($_POST['barangay_name']) ? $_POST['barangay_name'] : '';

// Create a prepared statement
$stmt1 = $conn -> stmt_init();

if ($stmt1 -> prepare("
    UPDATE `barangays`
    SET barangay_name = ? 
    WHERE barangay_id = ?;")) {

  // Bind parameters
  $stmt1 -> bind_param("ss", $barangay_name, $barangay_id);

  // Execute query
  $stmt1 -> execute();

  // Close statement
  $stmt1 -> close();

} else {
  echo "Query Error (brgy_update.php stmt1->prepare) : $stmt1->errno : $stmt1->error";
}

$conn -> close();

?>