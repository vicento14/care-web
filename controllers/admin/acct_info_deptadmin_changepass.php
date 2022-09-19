<?php

//Update Password

include('../database/config.php');

$account_id = ($conn -> real_escape_string($_POST['account_id'])) ? $conn -> real_escape_string($_POST['account_id']) : '';
$new_pass = ($conn -> real_escape_string($_POST['new_pass'])) ? $conn -> real_escape_string($_POST['new_pass']) : '';

// password hash algorithm
$new_pass = hash('sha512', $new_pass);

// Create a prepared statement
$stmt1 = $conn -> stmt_init();
$stmt2 = $conn -> stmt_init();

if ($stmt1 -> prepare(
  "SELECT account_id, account_auth_id 
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
  }

  // Close statement
  $stmt1 -> close();

} else {
  echo "Query Error (acct_info_resident_changepass.php stmt1->prepare) : $stmt1->errno : $stmt1->error";
}

if ($stmt2 -> prepare(
  "UPDATE `account_auths` 
  SET password = ? 
  WHERE account_auth_id = ?;")) {

  // Bind parameters
  $stmt2 -> bind_param("ss", $new_pass, $account_auth_id);

  // Execute query
  $stmt2 -> execute();

  // Close statement
  $stmt2 -> close();

} else {
  echo "Query Error (acct_info_resident_changepass.php stmt2->prepare) : $stmt2->errno : $stmt2->error";
}

$conn -> close();

?>