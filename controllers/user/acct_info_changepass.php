<?php
include('../database/config.php');

$result_array = array();
$result_array['success'] = 1;
$result_array['message'] = "";

$account_auth_id = ($conn -> real_escape_string($_POST['account_auth_id'])) ? $conn -> real_escape_string($_POST['account_auth_id']) : $result_array['success'] = 0;
$old_pass = ($conn -> real_escape_string($_POST['old_pass'])) ? $conn -> real_escape_string($_POST['old_pass']) : $result_array['success'] = 0;
$new_pass = ($conn -> real_escape_string($_POST['new_pass'])) ? $conn -> real_escape_string($_POST['new_pass']) : $result_array['success'] = 0;
$check_old_pass = "";

if ($result_array['success'] != 0) {

    // password hash algorithm
    $old_pass = hash('sha512', $old_pass);
    $new_pass = hash('sha512', $new_pass);

    // Create a prepared statement
    $stmt1 = $conn -> stmt_init();
    $stmt2 = $conn -> stmt_init();

    if ($stmt1 -> prepare("SELECT password FROM `account_auths` WHERE account_auth_id = ?;")) {
        // Bind parameters
        $stmt1 -> bind_param("s", $account_auth_id);

        // Execute query
        $stmt1 -> execute();

        // Fetch values
        $result = $stmt1 -> get_result();
        while($row = $result -> fetch_assoc()){
            $check_old_pass = $row['password'];
        }

        // Close statement
        $stmt1 -> close();
    } else {
        $result_array['success'] = 0;
        $result_array['message'] .= "Query Error (acct_info_changepass.php stmt1->prepare) : $stmt1->errno : $stmt1->error";
    }

    if ($check_old_pass == $old_pass) {
        if ($stmt2 -> prepare("UPDATE `account_auths` SET password = ? WHERE account_auth_id = ?;")) {
            // Bind parameters
            $stmt2 -> bind_param("ss", $new_pass, $account_auth_id);
        
            // Execute query
            $stmt2 -> execute();
        
            // Close statement
            $stmt2 -> close();
        } else {
            $result_array['success'] = 0;
            $result_array['message'] .= "Query Error (acct_info_changepass.php stmt1->prepare) : $stmt2->errno : $stmt2->error";
        }
    } else {
        $result_array['success'] = 0;
        $result_array['message'] .= "Incorrect Old Password";
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