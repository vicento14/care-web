<?php
include('../database/config.php');

$result_array = array();
$result_array['success'] = 1;
$result_array['message'] = "";

$account_id = ($conn -> real_escape_string($_POST['account_id'])) ? $conn -> real_escape_string($_POST['account_id']) : $result_array['success'] = 0;
$email = ($conn -> real_escape_string($_POST['email'])) ? $conn -> real_escape_string($_POST['email']) : $result_array['success'] = 0;
$user_email = $email;
$account_auth_id = 0;

if ($result_array['success'] != 0) {

    if (!filter_var($user_email, FILTER_VALIDATE_EMAIL)) {
        $result_array['success'] = 0;
        $result_array['message'] .= "Invalid Email Format";
    } else {
        // Create a prepared statement
        $stmt1 = $conn -> stmt_init();
        $stmt2 = $conn -> stmt_init();
        $stmt3 = $conn -> stmt_init();

        if ($stmt1 -> prepare("UPDATE `account_information` SET email = ? WHERE account_id = ?;")) {
            // Bind parameters
            $stmt1 -> bind_param("ss", $email, $account_id);

            // Execute query
            $stmt1 -> execute();

            // Close statement
            $stmt1 -> close();

        } else {
            $result_array['success'] = 0;
            $result_array['message'] .= "Query Error (acct_info_email.php stmt1->prepare) : $stmt1->errno : $stmt1->error";
        }

        if ($stmt2 -> prepare("SELECT account_auth_id FROM `account_information` WHERE account_id = ?")) {
            // Bind parameters
            $stmt2 -> bind_param("s", $account_id);

            // Execute query
            $stmt2 -> execute();
            
            // Fetch values
            $result = $stmt2 -> get_result();
            while($row = $result -> fetch_assoc()){
                $account_auth_id = intval($row['account_auth_id']);
            }

            // Close statement
            $stmt2 -> close();

        } else {
            $result_array['success'] = 0;
            $result_array['message'] .= "Query Error (acct_info_email.php stmt2->prepare) : $stmt2->errno : $stmt2->error";
        }

        if ($stmt3 -> prepare("UPDATE `account_auths` SET user_email = ? WHERE account_auth_id = ?;")) {
            // Bind parameters
            $stmt3 -> bind_param("ss", $user_email, $account_auth_id);

            // Execute query
            $stmt3 -> execute();

            // Close statement
            $stmt3 -> close();

        } else {
            $result_array['success'] = 0;
            $result_array['message'] .= "Query Error (acct_info_email.php stmt3->prepare) : $stmt3->errno : $stmt3->error";
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