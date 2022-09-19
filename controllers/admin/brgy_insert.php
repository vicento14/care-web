<?php

//Insert

include('../database/config.php');

$barangay_name = ($_POST['barangay_name']) ? $_POST['barangay_name'] : '';
$barangay_id = 0;

// Create a prepared statement
$stmt1 = $conn -> stmt_init();
$stmt2 = $conn -> stmt_init();

if ($stmt1 -> prepare("
SELECT barangay_id FROM `barangays` ORDER BY barangay_id DESC LIMIT 1;")) {
  // Execute query
  $stmt1 -> execute();

  // Fetch values
  $result = $stmt1 -> get_result();
  $numRows = $result -> num_rows;
  if ($numRows > 0) {
    while($row = $result -> fetch_assoc()){
      $barangay_id = intval($row['barangay_id']);
    }
  }

  // Close statement
  $stmt1 -> close();

  $barangay_id++;

} else {
  echo "Query Error (brgy_insert.php stmt1->prepare) : $stmt1->errno : $stmt1->error";
}

if ($stmt2 -> prepare("
INSERT INTO `barangays` (barangay_id, barangay_name) 
VALUES (?, ?);")) {
  // Bind parameters
  $stmt2 -> bind_param("ss", $barangay_id, $barangay_name);

  // Execute query
  $stmt2 -> execute();

  // Close statement
  $stmt2 -> close();
} else {
  echo "Query Error (brgy_insert.php stmt2->prepare) : $stmt2->errno : $stmt2->error";
}

$conn -> close();

?>