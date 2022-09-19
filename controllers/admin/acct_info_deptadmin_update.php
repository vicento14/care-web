<?php

//Update

include('../database/config.php');

$user_email = ($conn -> real_escape_string($_POST['user_email'])) ? $conn -> real_escape_string($_POST['user_email']) : '';
$account_name = ($_POST['account_name']) ? $_POST['account_name'] : '';
$dept_id = ($conn -> real_escape_string($_POST['dept_id'])) ? $conn -> real_escape_string($_POST['dept_id']) : '';
$account_id = ($conn -> real_escape_string($_POST['account_id'])) ? $conn -> real_escape_string($_POST['account_id']) : '';
$account_auth_id = "";
$admin_id = "";
$admin_name = $account_name;

// Create a prepared statement
$stmt1 = $conn -> stmt_init();
$stmt2 = $conn -> stmt_init();
$stmt3 = $conn -> stmt_init();
$stmt4 = $conn -> stmt_init();
$stmt5 = $conn -> stmt_init();

if ($stmt1 -> prepare(
  "SELECT account_information.account_id, 
  account_information.account_auth_id, 
  account_information.admin_id, 
  admins_departments.dept_id 
  FROM `account_information`
  INNER JOIN `account_auths` ON account_information.account_auth_id = account_auths.account_auth_id 
  INNER JOIN `admins_departments` ON account_information.admin_id = admins_departments.admin_id 
  WHERE account_information.account_id = ?;")) {

  // Bind parameters
  $stmt1 -> bind_param("s", $account_id);

  // Execute query
  $stmt1 -> execute();

  // Fetch values
  $result = $stmt1 -> get_result();
  while($row = $result -> fetch_assoc()){
    $account_auth_id = $row['account_auth_id'];
    $admin_id = $row['admin_id'];
  }

  // Close statement
  $stmt1 -> close();

} else {
  echo "Query Error (acct_info_deptadmin_update.php stmt1->prepare) : $stmt1->errno : $stmt1->error";
}

if ($stmt2 -> prepare(
  "UPDATE `account_auths` 
  SET user_email = ? 
  WHERE account_auth_id = ?;")) {

  // Bind parameters
  $stmt2 -> bind_param("ss", $user_email, $account_auth_id);

  // Execute query
  $stmt2 -> execute();

  // Close statement
  $stmt2 -> close();

} else {
  echo "Query Error (acct_info_deptadmin_update.php stmt2->prepare) : $stmt2->errno : $stmt2->error";
}

if ($stmt3 -> prepare(
  "UPDATE `accounts`
  SET account_name = ? 
  WHERE account_id = ?;")) {

  // Bind parameters
  $stmt3 -> bind_param("ss", $account_name, $account_id);

  // Execute query
  $stmt3 -> execute();

  // Close statement
  $stmt3 -> close();

} else {
  echo "Query Error (acct_info_deptadmin_update.php stmt3->prepare) : $stmt3->errno : $stmt3->error";
}

if ($stmt4 -> prepare(
  "UPDATE `admins`
  SET admin_name = ? 
  WHERE admin_id = ?;")) {

  // Bind parameters
  $stmt4 -> bind_param("ss", $admin_name, $admin_id);

  // Execute query
  $stmt4 -> execute();

  // Close statement
  $stmt4 -> close();

} else {
  echo "Query Error (acct_info_deptadmin_update.php stmt4->prepare) : $stmt4->errno : $stmt4->error";
}

if ($stmt5 -> prepare(
  "UPDATE `admins_departments`
  SET dept_id = ? 
  WHERE admin_id = ?;")) {

  // Bind parameters
  $stmt5 -> bind_param("ss", $dept_id, $admin_id);

  // Execute query
  $stmt5 -> execute();

  // Close statement
  $stmt5 -> close();

} else {
  echo "Query Error (acct_info_deptadmin_update.php stmt5->prepare) : $stmt5->errno : $stmt5->error";
}

$conn -> close();

?>