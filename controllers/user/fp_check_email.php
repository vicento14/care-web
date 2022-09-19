<?php

session_start();

include('../database/config.php');

$result_array = array();
$result_array['success'] = 1;
$result_array['message'] = "";

$email = ($conn -> real_escape_string($_POST['email'])) ? $conn -> real_escape_string($_POST['email']) : $result_array['success'] = 0;
$success = 0;

if ($result_array['success'] != 0) {

  // Create a prepared statement
  $stmt1 = $conn -> stmt_init();

  if ($stmt1 -> prepare(
      "SELECT account_auth_id FROM `account_auths` WHERE user_email = ?;")) {

    // Bind parameters
    $stmt1 -> bind_param("s", $email);

    // Execute query
    $stmt1 -> execute();

    // Fetch values
    $result = $stmt1 -> get_result();
    $numRows = $result -> num_rows;
    if ($numRows > 0) {
        $_SESSION['email'] = $email;
        $success = 1;
    } else {
        $result_array['success'] = 0;
        $result_array['message'] .= "Email not found ";
    }

    // Close statement
    $stmt1 -> close();

  } else {
    $result_array['success'] = 0;
    $result_array['message'] .= "Query Error (fp_check_email.php stmt1->prepare) : $stmt1->errno : $stmt1->error";
  }

} else {
  $result_array['message'] .= "Please fill out the blank fields ";
}

if ($result_array['success'] != 0) {
  $result_array['success'] = 1;
  $result_array['message'] = "Success";
}

echo json_encode($result_array);

$conn -> close();

?>