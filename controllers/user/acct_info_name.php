<?php
include('../database/config.php');

$result_array = array();
$result_array['success'] = 1;
$result_array['message'] = "";

$account_id = ($conn -> real_escape_string($_POST['account_id'])) ? $conn -> real_escape_string($_POST['account_id']) : $result_array['success'] = 0;
$account_name = ($_POST['account_name']) ? $_POST['account_name'] : $result_array['success'] = 0;
$user_id = ($conn -> real_escape_string($_POST['user_id'])) ? $conn -> real_escape_string($_POST['user_id']) : $result_array['success'] = 0;
$user_name = $account_name;

if ($result_array['success'] != 0) {

    if (!preg_match("/^[a-zA-Z-' ]*$/",$account_name)) {
        $result_array['success'] = 0;
        $result_array['message'] .= "Only letters and white space allowed";
    } else if (strlen($account_name) < 2) {
        $result_array['success'] = 0;
        $result_array['message'] .= "Account Name should at least 2 or more characters";
    } else {
        // Create a prepared statement
        $stmt1 = $conn -> stmt_init();
        $stmt2 = $conn -> stmt_init();

        if ($user_id != "") {
            if ($stmt1 -> prepare("UPDATE `accounts` SET account_name = ? WHERE account_id = ?;")) {
                // Bind parameters
                $stmt1 -> bind_param("ss", $account_name, $account_id);
            
                // Execute query
                $stmt1 -> execute();
            
                // Close statement
                $stmt1 -> close();
            
            } else {
                $result_array['success'] = 0;
                $result_array['message'] .= "Query Error (acct_info_name.php stmt1->prepare) : $stmt1->errno : $stmt1->error";
            }
            
            if ($stmt2 -> prepare("
            UPDATE `users` 
            SET user_name = ? 
            WHERE user_id = ?;")) {
                // Bind parameters
                $stmt2 -> bind_param("ss", $user_name, $user_id);
            
                // Execute query
                $stmt2 -> execute();
            
                // Close statement
                $stmt2 -> close();
            
            } else {
                $result_array['success'] = 0;
                $result_array['message'] .= "Query Error (acct_info_name.php stmt2->prepare) : $stmt2->errno : $stmt2->error";
            }
        }
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