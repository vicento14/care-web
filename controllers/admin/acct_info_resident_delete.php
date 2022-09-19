<?php

//Delete

include('../database/config.php');

$account_id = ($conn -> real_escape_string($_POST['account_id'])) ? $conn -> real_escape_string($_POST['account_id']) : '';
$account_role_id = 0;
$account_auth_id = 0;

// Create a prepared statement
$stmt1 = $conn -> stmt_init();
$stmt2 = $conn -> stmt_init();
$stmt3 = $conn -> stmt_init();
$stmt4 = $conn -> stmt_init();

if ($stmt1 -> prepare(
  "SELECT account_id, account_role_id, account_auth_id  
  FROM `account_information`
  WHERE account_id = ?;")) {
  
  // Bind parameters
  $stmt1 -> bind_param("s", $account_id);

  // Execute query
  $stmt1 -> execute();
  
  // Fetch values
  $result = $stmt1 -> get_result();
  while($row = $result -> fetch_assoc()){
    $account_role_id = intval($row['account_role_id']);
    $account_auth_id = intval($row['account_auth_id']);
  }

  // Close statement
  $stmt1 -> close();

} else {
  echo "Query Error (acct_info_resident_delete.php stmt1->prepare) : $stmt1->errno : $stmt1->error";
}

if ($stmt2 -> prepare("
UPDATE `account_information`
SET account_role_id = 0, 
account_auth_id = 0, 
is_deleted = 1
WHERE account_id = ?;")) {
  // Bind parameters
  $stmt2 -> bind_param("s", $account_id);

  // Execute query
  $stmt2 -> execute();

  // Close statement
  $stmt2 -> close();
} else {
  echo "Query Error (acct_info_resident_delete.php stmt2->prepare) : $stmt2->errno : $stmt2->error";
}

if ($stmt3 -> prepare("DELETE FROM `account_roles` WHERE account_role_id = ?;")) {
  // Bind parameters
  $stmt3 -> bind_param("s", $account_role_id);

  // Execute query
  $stmt3 -> execute();

  // Close statement
  $stmt3 -> close();
} else {
  echo "Query Error (acct_info_resident_delete.php stmt3->prepare) : $stmt3->errno : $stmt3->error";
}

if ($stmt4 -> prepare("DELETE FROM `account_auths` WHERE account_auth_id = ?;")) {
  // Bind parameters
  $stmt4 -> bind_param("s", $account_auth_id);

  // Execute query
  $stmt4 -> execute();

  // Close statement
  $stmt4 -> close();
} else {
  echo "Query Error (acct_info_resident_delete.php stmt4->prepare) : $stmt4->errno : $stmt4->error";
}

$conn -> close();

?>