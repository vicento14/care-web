<?php
include('../database/config.php');
require_once './acct_create_folder.php';

$result_array = array();
$result_array['success'] = 1;
$result_array['message'] = "";

$first_name = ($_POST['first_name']) ? $_POST['first_name'] : $result_array['success'] = 0;
$last_name = ($_POST['last_name']) ? $_POST['last_name'] : $result_array['success'] = 0;
$email = ($conn -> real_escape_string($_POST['email'])) ? $conn -> real_escape_string($_POST['email']) : $result_array['success'] = 0;
$password = ($conn -> real_escape_string($_POST['password'])) ? $conn -> real_escape_string($_POST['password']) : $result_array['success'] = 0;
$cellphone_number = ($conn -> real_escape_string($_POST['cellphone_number'])) ? $conn -> real_escape_string($_POST['cellphone_number']) : $result_array['success'] = 0;
$barangay_id = ($conn -> real_escape_string($_POST['barangay_id'])) ? $conn -> real_escape_string($_POST['barangay_id']) : $result_array['success'] = 0;

if ($result_array['success'] != 0) {

    $user_email = $email;
    $account_name = "{$first_name} {$last_name}";
    $user_name = $account_name;
    $account_id = 0;
    $user_id = 0;
    $account_auth_id = $account_id;
    $account_role_id = $account_id;

    if (!preg_match("/^[a-zA-Z-' ]*$/",$account_name)) {
        $result_array['success'] = 0;
        $result_array['message'] .= "Only letters and white space allowed";
    }

    if (!filter_var($user_email, FILTER_VALIDATE_EMAIL)) {
        $result_array['success'] = 0;
        $result_array['message'] .= "Invalid Email Format";
    }

    if(!preg_match("/^[0-9]{11}$/", $cellphone_number)) {
        $result_array['success'] = 0;
        $result_array['message'] .= "Invalid Phone Number Format";
    }

    // password hash algorithm
    $password = hash('sha512', $password);

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
    $stmt11 = $conn -> stmt_init();

    if ($stmt1 -> prepare("SELECT user_email FROM `account_auths` WHERE user_email = ?;")) {
        // Bind parameters
        $stmt1 -> bind_param("s", $user_email);
        
        // Execute query
        $stmt1 -> execute();

        // Fetch values
        $result = $stmt1 -> get_result();
        $numRows = $result -> num_rows;
        if ($numRows > 0) {
            $result_array['success'] = 0;
            $result_array['message'] .= "Email Exist";
        }

        // Close statement
        $stmt1 -> close();

    } else {
        $result_array['success'] = 0;
        $result_array['message'] .= "Query Error (sign-up.php stmt1->prepare) : $stmt1->errno : $stmt1->error";
    }

    if ($stmt2 -> prepare("SELECT * FROM `barangays` WHERE barangay_id = ?;")) {
        // Bind parameters
        $stmt2 -> bind_param("s", $barangay_id);
        
        // Execute query
        $stmt2 -> execute();

        // Fetch values
        $result = $stmt2 -> get_result();
        $numRows = $result -> num_rows;
        if ($numRows == 0) {
            $result_array['success'] = 0;
            $result_array['message'] .= "The barangay you choose is not found. Contact Main Administrator or Developer to fix the issue";
        }

        // Close statement
        $stmt2 -> close();

    } else {
        $result_array['success'] = 0;
        $result_array['message'] .= "Query Error (sign-up.php stmt2->prepare) : $stmt2->errno : $stmt2->error";
    }

    if ($result_array['success'] != 0) {
        if ($stmt3 -> prepare("SELECT account_id FROM `accounts` ORDER BY account_id DESC LIMIT 1;")) {
            // Execute query
            $stmt3 -> execute();

            // Fetch values
            $result = $stmt3 -> get_result();
            $numRows = $result -> num_rows;
            if ($numRows > 0) {
                while($row = $result -> fetch_assoc()){
                    $account_id = intval($row['account_id']);
                }
            }

            // Close statement
            $stmt3 -> close();

            $account_id++;

        } else {
            $result_array['success'] = 0;
            $result_array['message'] .= "Query Error (sign-up.php stmt3->prepare) : $stmt3->errno : $stmt3->error";
        }

        if ($stmt4 -> prepare("SELECT account_auth_id FROM `account_auths` ORDER BY account_auth_id DESC LIMIT 1;")) {
            // Execute query
            $stmt4 -> execute();
        
            // Fetch values
            $result = $stmt4 -> get_result();
            $numRows = $result -> num_rows;
            if ($numRows > 0) {
                while($row = $result -> fetch_assoc()){
                    $account_auth_id = intval($row['account_auth_id']);
                }
            }
        
            // Close statement
            $stmt4 -> close();
        
            $account_auth_id++;
        
        } else {
            $result_array['success'] = 0;
            $result_array['message'] .= "Query Error (sign-up.php stmt4->prepare) : $stmt4->errno : $stmt4->error";
        }

        if ($stmt5 -> prepare("SELECT account_role_id FROM `account_roles` ORDER BY account_role_id DESC LIMIT 1;")) {
            // Execute query
            $stmt5 -> execute();

            // Fetch values
            $result = $stmt5 -> get_result();
            $numRows = $result -> num_rows;
            if ($numRows > 0) {
                while($row = $result -> fetch_assoc()){
                    $account_role_id = intval($row['account_role_id']);
                }
            }

            // Close statement
            $stmt5 -> close();

            $account_role_id++;

        } else {
            $result_array['success'] = 0;
            $result_array['message'] .= "Query Error (sign-up.php stmt5->prepare) : $stmt4->errno : $stmt5->error";
        }

        if ($stmt6 -> prepare("SELECT user_id FROM `users` ORDER BY user_id DESC LIMIT 1;")) {
            // Execute query
            $stmt6 -> execute();

            // Fetch values
            $result = $stmt6 -> get_result();
            $numRows = $result -> num_rows;
            if ($numRows > 0) {
                while($row = $result -> fetch_assoc()){
                    $user_id = intval($row['user_id']);
                }
            }

            // Close statement
            $stmt6 -> close();

            $user_id++;

        } else {
            $result_array['success'] = 0;
            $result_array['message'] .= "Query Error (sign-up.php stmt6->prepare) : $stmt6->errno : $stmt6->error";
        }

        if ($stmt7 -> prepare(
        "INSERT INTO `accounts` (account_id, account_name, account_photo_filename, account_photo_url)
        VALUES (?, ?, '', '');")) {
            // Bind parameters
            $stmt7 -> bind_param("ss", $account_id, $account_name);

            // Execute query
            $stmt7 -> execute();

            // Close statement
            $stmt7 -> close();
        } else {
            $result_array['success'] = 0;
            $result_array['message'] .= "Query Error (sign-up.php stmt7->prepare) : $stmt7->errno : $stmt7->error";
        }

        if ($stmt8 -> prepare(
        "INSERT INTO `account_auths` (account_auth_id, user_email, password, valid_id_filename, valid_id_url, is_verified, date_verified)
        VALUES (?, ?, ?, '', '', 0, '0000-00-00 00:00:00');")) {
            // Bind parameters
            $stmt8 -> bind_param("sss", $account_auth_id, $user_email, $password);

            // Execute query
            $stmt8 -> execute();

            // Close statement
            $stmt8 -> close();
        } else {
            $result_array['success'] = 0;
            $result_array['message'] .= "Query Error (sign-up.php stmt8->prepare) : $stmt8->errno : $stmt8->error";
        }

        if ($stmt9 -> prepare(
        "INSERT INTO `account_roles` (account_role_id, is_admin, is_user) 
        VALUES (?, 0, 1);")) {
            // Bind parameters
            $stmt9 -> bind_param("s", $account_role_id);

            // Execute query
            $stmt9 -> execute();

            // Close statement
            $stmt9 -> close();
        } else {
            $result_array['success'] = 0;
            $result_array['message'] .= "Query Error (sign-up.php stmt9->prepare) : $stmt9->errno : $stmt9->error";
        }

        if ($stmt10 -> prepare(
        "INSERT INTO `users` (user_id, user_name, report_left, report_date)
        VALUES (?, ?, 10, '0000-00-00 00:00:00');")) {
            // Bind parameters
            $stmt10 -> bind_param("ss", $user_id, $user_name);

            // Execute query
            $stmt10 -> execute();

            // Close statement
            $stmt10 -> close();
        } else {
            $result_array['success'] = 0;
            $result_array['message'] .= "Query Error (sign-up.php stmt10->prepare) : $stmt10->errno : $stmt10->error";
        }

        if ($stmt11 -> prepare(
        "INSERT INTO `account_information` (account_id, account_role_id, 
        account_auth_id, admin_id, user_id, barangay_id, email, r_email, cellphone_number, active, is_deleted)
        VALUES (?, ?, ?, 0, ?, ?, ?, ?, ?, 0, 0);")) {
            // Bind parameters
            $stmt11 -> bind_param("ssssssss", $account_id, $account_role_id, $account_auth_id, $user_id, $barangay_id, $email, $email, $cellphone_number);

            // Execute query
            $stmt11 -> execute();

            // Close statement
            $stmt11 -> close();
        } else {
            $result_array['success'] = 0;
            $result_array['message'] .= "Query Error (sign-up.php stmt11->prepare) : $stmt11->errno : $stmt11->error";
        }

        $result_array['success'] = acct_create_folder($user_id, 1);

    }
    
} else {
    $result_array['message'] .= "Please fill out the blank fields";
}

if ($result_array['success'] != 0) {
    $result_array['success'] = 1;
    $result_array['message'] = "Sign Up Successfully";
}

echo json_encode($result_array);

$conn -> close();

?>