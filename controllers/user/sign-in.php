<?php
include('../database/config.php');

$result_array = array();
$result_array['session'] = array();
$result_array['success'] = 1;
$result_array['message'] = "";

$user_email = ($conn -> real_escape_string($_POST['user_email'])) ? $conn -> real_escape_string($_POST['user_email']) : $result_array['success'] = 0;
$password = ($conn -> real_escape_string($_POST['password'])) ? $conn -> real_escape_string($_POST['password']) : $result_array['success'] = 0;

if ($result_array['success'] != 0) {

    $account_id = 0;
    $account_auth_id = 0;
    $is_verified = 0;
    $verification_status = "0";

    // password hash algorithm
    $password = hash('sha512', $password);

    // Create a prepared statement
    $stmt1 = $conn -> stmt_init();
    $stmt2 = $conn -> stmt_init();
    $stmt3 = $conn -> stmt_init();
    $stmt4 = $conn -> stmt_init();
    $stmt5 = $conn -> stmt_init();

    if ($stmt1 -> prepare(
    "SELECT account_auth_id, is_verified, valid_id_filename, date_verified
    FROM `account_auths` 
    WHERE user_email = ? 
    AND password = ?;")) {
        // Bind parameters
        $stmt1 -> bind_param("ss", $user_email, $password);

        // Execute query
        $stmt1 -> execute();

        // Determine if account exist
        $result = $stmt1 -> get_result();
        $numRows = $result -> num_rows;
        if ($numRows > 0) {

            // Fetch values
            while($row = $result -> fetch_assoc()){
                $account_auth_id = $row['account_auth_id'];
                $is_verified = $row['is_verified'];
                if ($is_verified != 0) {
                    $verification_status = "4"; //Verified
                } else if ($row['valid_id_filename'] != "") {
                    $verification_status = "2"; //Verification on process
                } else if ($row['date_verified'] != "0000-00-00 00:00:00") {
                    $verification_status = "3"; //Not Accepted
                } else {
                    $verification_status = "1"; //Not Verified
                }
            }

            if ($stmt2 -> prepare(
            "SELECT is_deleted 
            FROM `account_information` 
            WHERE account_auth_id = ? 
            AND is_deleted = 0;")) {
            
                // Bind parameters
                $stmt2 -> bind_param("s", $account_auth_id);

                // Execute query
                $stmt2 -> execute();
                
                // Fetch values
                $result = $stmt2 -> get_result();
                $numRows = $result -> num_rows;
                if ($numRows == 0) {
                    $result_array['success'] = 0;
                    $result_array['message'] .= "This Account Doesn't Exist";
                }

                // Close statement
                $stmt2 -> close();

            } else {
                $result_array['success'] = 0;
                $result_array['message'] .= "Query Error (sign-in.php stmt2->prepare) : $stmt2->errno : $stmt2->error   ";
            }
    
            if ($stmt3 -> prepare(
            "SELECT user_id 
            FROM `account_information` 
            WHERE account_auth_id = ? 
            AND admin_id = 0;")) {
            
                // Bind parameters
                $stmt3 -> bind_param("s", $account_auth_id);

                // Execute query
                $stmt3 -> execute();
                
                // Fetch values
                $result = $stmt3 -> get_result();
                $numRows = $result -> num_rows;
                if ($numRows == 0) {
                    $result_array['success'] = 0;
                    $result_array['message'] .= "This Account Doesn't Match Here";
                }

                // Close statement
                $stmt3 -> close();

            } else {
                $result_array['success'] = 0;
                $result_array['message'] .= "Query Error (sign-in.php stmt3->prepare) : $stmt3->errno : $stmt3->error   ";
            }

            if ($result_array['success'] != 0) {

                if ($stmt4 -> prepare(
                "SELECT account_information.account_id, 
                accounts.account_name, 
                accounts.account_photo_filename, 
                accounts.account_photo_url, 
                account_information.account_role_id, 
                account_roles.is_admin, account_roles.is_user, 
                account_information.account_auth_id, 
                account_auths.user_email, 
                account_information.email, 
                account_information.r_email, 
                account_information.cellphone_number, 
                account_information.user_id, 
                account_information.barangay_id 
                FROM `account_information`
                INNER JOIN `accounts` ON account_information.account_id = accounts.account_id 
                INNER JOIN `account_roles` ON account_information.account_role_id = account_roles.account_role_id 
                INNER JOIN `account_auths` ON account_information.account_auth_id = account_auths.account_auth_id 
                WHERE account_information.account_auth_id = ?;")) {
                
                    // Bind parameters
                    $stmt4 -> bind_param("s", $account_auth_id);

                    // Execute query
                    $stmt4 -> execute();
                    
                    // Fetch values
                    $result = $stmt4 -> get_result();
                    while($row = $result -> fetch_assoc()){
                        $index['account_id'] = $row['account_id'];
                        $index['account_auth_id'] = $row['account_auth_id'];
                        $index['account_name'] = $row['account_name'];
                        $index['account_photo_filename'] = $row['account_photo_filename'];
                        $index['account_photo_url'] = $row['account_photo_url'];
                        $index['email'] = $row['email'];
                        $index['r_email'] = $row['r_email'];
                        $index['cellphone_number'] = $row['cellphone_number'];
                        $index['user_id'] = $row['user_id'];
                        $index['barangay_id'] = $row['barangay_id'];
                        $index['is_verified'] = $is_verified;
                        $index['verification_status'] = $verification_status;
                        $account_id = $row['account_id'];
                    }

                    array_push($result_array['session'], $index);

                    // Close statement
                    $stmt4 -> close();

                } else {
                    $result_array['success'] = 0;
                    $result_array['message'] .= "Query Error (sign-in.php stmt4->prepare) : $stmt4->errno : $stmt4->error   ";
                }

                if ($stmt5 -> prepare(
                "UPDATE `account_information` 
                SET active = 1 
                WHERE account_id = ?;")) {
                
                    // Bind parameters
                    $stmt5 -> bind_param("s", $account_id);

                    // Execute query
                    $stmt5 -> execute();

                    // Close statement
                    $stmt5 -> close();

                    $result_array['success'] = 1;
                    $result_array['message'] .= "Sign In Successfully";

                } else {
                    $result_array['success'] = 0;
                    $result_array['message'] .= "Query Error (sign-in.php stmt5->prepare) : $stmt5->errno : $stmt5->error    ";
                }

            }

        } else {
            $result_array['success'] = 0;
            $result_array['message'] .= "Invalid Email/Password! Contact Main Administrator or Developer to recover your account.   ";
        }

        // Close statement
        $stmt1 -> close();

    } else {
        $result_array['success'] = 0;
        $result_array['message'] .= "Query Error (sign-in.php stmt1->prepare) : $stmt1->errno : $stmt1->error    ";
    }
    
} else {
    $result_array['message'] .= "Please fill out the blank fields";
}

echo json_encode($result_array);

$conn -> close();

?>