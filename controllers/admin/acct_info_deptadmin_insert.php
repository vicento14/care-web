<?php

//Insert

include('../database/config.php');

$user_email = ($conn -> real_escape_string($_POST['user_email'])) ? $conn -> real_escape_string($_POST['user_email']) : '';
$account_name = ($_POST['account_name']) ? $_POST['account_name'] : '';
$dept_id = ($conn -> real_escape_string($_POST['dept_id'])) ? $conn -> real_escape_string($_POST['dept_id']) : '';
$account_id = 0;
$admin_id = 0;
$account_auth_id = $account_id;
$account_role_id = $account_id;
$admin_name = $account_name;

date_default_timezone_set("Asia/Manila");
$date_created = date('Y-m-d H:i:s');

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

if ($stmt1 -> prepare("SELECT account_id FROM `accounts` ORDER BY account_id DESC LIMIT 1;")) {
  // Execute query
  $stmt1 -> execute();

  // Fetch values
  $result = $stmt1 -> get_result();
  $numRows = $result -> num_rows;
  if ($numRows > 0) {
    while($row = $result -> fetch_assoc()){
      $account_id = intval($row['account_id']);
    }
  }

  // Close statement
  $stmt1 -> close();

  $account_id++;

} else {
  echo "Query Error (acct_info_deptadmin_insert.php stmt1->prepare) : $stmt1->errno : $stmt1->error";
}

if ($stmt2 -> prepare("SELECT account_auth_id FROM `account_auths` ORDER BY account_auth_id DESC LIMIT 1;")) {
  // Execute query
  $stmt2 -> execute();

  // Fetch values
  $result = $stmt2 -> get_result();
  $numRows = $result -> num_rows;
  if ($numRows > 0) {
    while($row = $result -> fetch_assoc()){
      $account_auth_id = intval($row['account_auth_id']);
    }
  }

  // Close statement
  $stmt2 -> close();

  $account_auth_id++;

} else {
  echo "Query Error (acct_info_deptadmin_insert.php stmt2->prepare) : $stmt2->errno : $stmt2->error";
}

if ($stmt3 -> prepare("SELECT account_role_id FROM `account_roles` ORDER BY account_role_id DESC LIMIT 1;")) {
  // Execute query
  $stmt3 -> execute();

  // Fetch values
  $result = $stmt3 -> get_result();
  $numRows = $result -> num_rows;
  if ($numRows > 0) {
    while($row = $result -> fetch_assoc()){
      $account_role_id = intval($row['account_role_id']);
    }
  }

  // Close statement
  $stmt3 -> close();

  $account_role_id++;

} else {
  echo "Query Error (acct_info_deptadmin_insert.php stmt3->prepare) : $stmt3->errno : $stmt3->error";
}

if ($stmt4 -> prepare("SELECT admin_id FROM `admins` ORDER BY admin_id DESC LIMIT 1;")) {
  // Execute query
  $stmt4 -> execute();

  // Fetch values
  $result = $stmt4 -> get_result();
  $numRows = $result -> num_rows;
  if ($numRows > 0) {
    while($row = $result -> fetch_assoc()){
      $admin_id = intval($row['admin_id']);
    }
  }

  // Close statement
  $stmt4 -> close();

  $admin_id++;

} else {
  echo "Query Error (acct_info_deptadmin_insert.php stmt4->prepare) : $stmt4->errno : $stmt4->error";
}

if ($stmt5 -> prepare("
INSERT INTO `accounts` (account_id, account_name, account_photo_filename, account_photo_url)
VALUES (?, ?, '', '');")) {
  // Bind parameters
  $stmt5 -> bind_param("ss", $account_id, $account_name);

  // Execute query
  $stmt5 -> execute();

  // Close statement
  $stmt5 -> close();
} else {
  echo "Query Error (acct_info_deptadmin_insert.php stmt5->prepare) : $stmt5->errno : $stmt5->error";
}

if ($stmt6 -> prepare("
INSERT INTO `account_auths` (account_auth_id, user_email, password, valid_id_filename, valid_id_url, is_verified, date_verified)
VALUES (?, ?, '', '', '', 0, '0000-00-00 00:00:00');")) {
  // Bind parameters
  $stmt6 -> bind_param("ss", $account_auth_id, $user_email);

  // Execute query
  $stmt6 -> execute();

  // Close statement
  $stmt6 -> close();
} else {
  echo "Query Error (acct_info_deptadmin_insert.php stmt6->prepare) : $stmt6->errno : $stmt6->error";
}

if ($stmt7 -> prepare("
INSERT INTO `account_roles` (account_role_id, is_admin, is_user)
VALUES (?, 1, 0);")) {
  // Bind parameters
  $stmt7 -> bind_param("s", $account_role_id);

  // Execute query
  $stmt7 -> execute();

  // Close statement
  $stmt7 -> close();
} else {
  echo "Query Error (acct_info_deptadmin_insert.php stmt7->prepare) : $stmt7->errno : $stmt7->error";
}

if ($stmt8 -> prepare("
INSERT INTO `admins` (admin_id, admin_name)
VALUES (?, ?);")) {
  // Bind parameters
  $stmt8 -> bind_param("ss", $admin_id, $admin_name);

  // Execute query
  $stmt8 -> execute();

  // Close statement
  $stmt8 -> close();
} else {
  echo "Query Error (acct_info_deptadmin_insert.php stmt8->prepare) : $stmt8->errno : $stmt8->error";
}

if ($stmt9 -> prepare("
INSERT INTO `admins_departments` (admin_id, dept_id)
VALUES (?, ?);")) {
  // Bind parameters
  $stmt9 -> bind_param("ss", $admin_id, $dept_id);

  // Execute query
  $stmt9 -> execute();

  // Close statement
  $stmt9 -> close();
} else {
  echo "Query Error (acct_info_deptadmin_insert.php stmt9->prepare) : $stmt9->errno : $stmt9->error";
}

if ($stmt10 -> prepare("
INSERT INTO `account_information` (account_id, account_role_id, 
account_auth_id, admin_id, user_id, barangay_id, email, r_email, cellphone_number, active, is_deleted, date_created)
VALUES (?, ?, ?, ?, 0, 0, ?, ?, '', 0, 0, ?);")) {
  // Bind parameters
  $stmt10 -> bind_param("sssssss", $account_id, $account_role_id, $account_auth_id, $admin_id, $user_email, $user_email, $date_created);

  // Execute query
  $stmt10 -> execute();

  // Close statement
  $stmt10 -> close();
} else {
  echo "Query Error (acct_info_deptadmin_insert.php stmt10->prepare) : $stmt10->errno : $stmt10->error";
}

echo $admin_id;

$conn -> close();

?>