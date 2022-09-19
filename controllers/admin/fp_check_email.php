<?php

session_start();

include('../database/config.php');

$user_email = ($conn -> real_escape_string($_POST['user_email'])) ? $conn -> real_escape_string($_POST['user_email']) : '';
$success = 0;

// Create a prepared statement
$stmt1 = $conn -> stmt_init();

if ($stmt1 -> prepare(
    "SELECT account_auth_id FROM `account_auths` WHERE user_email = ?;")) {

  // Bind parameters
  $stmt1 -> bind_param("s", $user_email);

  // Execute query
  $stmt1 -> execute();

  // Fetch values
  $result = $stmt1 -> get_result();
  $numRows = $result -> num_rows;
  if ($numRows > 0) {
      $_SESSION['email'] = $user_email;
      $success = 1;
  }

  // Close statement
  $stmt1 -> close();

} else {
  echo "Query Error (fp_check_email.php stmt1->prepare) : $stmt1->errno : $stmt1->error";
}

$conn -> close();

echo $success;

?>