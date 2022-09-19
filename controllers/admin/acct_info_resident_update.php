<?php

//Update

include('../database/config.php');

$user_email = ($conn -> real_escape_string($_POST['user_email'])) ? $conn -> real_escape_string($_POST['user_email']) : '';
$account_name = ($_POST['account_name']) ? $_POST['account_name'] : '';
$account_id = ($conn -> real_escape_string($_POST['account_id'])) ? $conn -> real_escape_string($_POST['account_id']) : '';
$barangay_id = ($conn -> real_escape_string($_POST['barangay_id'])) ? $conn -> real_escape_string($_POST['barangay_id']) : '';
$account_auth_id = "";
$user_id = "";
$user_name = $account_name;

// Create a prepared statement
$stmt1 = $conn -> stmt_init();
$stmt2 = $conn -> stmt_init();
$stmt3 = $conn -> stmt_init();
$stmt4 = $conn -> stmt_init();
$stmt5 = $conn -> stmt_init();

if ($stmt1 -> prepare("
  SELECT account_id, account_auth_id, user_id 
  FROM `account_information`
  WHERE account_id = ?;")) {

  // Bind parameters
  $stmt1 -> bind_param("s", $account_id);

  // Execute query
  $stmt1 -> execute();

  // Fetch values
  $result = $stmt1 -> get_result();
  while($row = $result -> fetch_assoc()){
    $account_auth_id = $row['account_auth_id'];
    $user_id = $row['user_id'];
  }

  // Close statement
  $stmt1 -> close();

} else {
  echo "Query Error (acct_info_resident_update.php stmt1->prepare) : $stmt1->errno : $stmt1->error";
}

if ($stmt2 -> prepare("
  UPDATE `account_auths` 
  SET user_email = ? 
  WHERE account_auth_id = ?;")) {

  // Bind parameters
  $stmt2 -> bind_param("ss", $user_email, $account_auth_id);

  // Execute query
  $stmt2 -> execute();

  // Close statement
  $stmt2 -> close();

} else {
  echo "Query Error (acct_info_resident_update.php stmt2->prepare) : $stmt2->errno : $stmt2->error";
}

if ($stmt3 -> prepare("
  UPDATE `accounts`
  SET account_name = ? 
  WHERE account_id = ?;")) {

  // Bind parameters
  $stmt3 -> bind_param("ss", $account_name, $account_id);

  // Execute query
  $stmt3 -> execute();

  // Close statement
  $stmt3 -> close();

} else {
  echo "Query Error (acct_info_resident_update.php stmt3->prepare) : $stmt3->errno : $stmt3->error";
}

if ($stmt4 -> prepare("
  UPDATE `users` 
  SET user_name = ? 
  WHERE user_id = ?;")) {

  // Bind parameters
  $stmt4 -> bind_param("ss", $user_name, $user_id);

  // Execute query
  $stmt4 -> execute();

  // Close statement
  $stmt4 -> close();

} else {
  echo "Query Error (acct_info_resident_update.php stmt4->prepare) : $stmt4->errno : $stmt4->error";
}

if ($stmt5 -> prepare("
  UPDATE `account_information` 
  SET barangay_id = ? 
  WHERE account_id = ?;")) {

  // Bind parameters
  $stmt5 -> bind_param("ss", $barangay_id, $account_id);

  // Execute query
  $stmt5 -> execute();

  // Close statement
  $stmt5 -> close();

} else {
  echo "Query Error (acct_info_resident_update.php stmt5->prepare) : $stmt5->errno : $stmt5->error";
}

$conn -> close();

?>