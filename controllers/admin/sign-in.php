<?php
include('../database/config.php');

session_start();

$user_email = ($conn -> real_escape_string($_POST['user_email'])) ? $conn -> real_escape_string($_POST['user_email']) : '';
$password = ($conn -> real_escape_string($_POST['password'])) ? $conn -> real_escape_string($_POST['password']) : '';
$recaptcha_response = $_POST['recaptcha_response'];
$recaptcha_secret_key = "6LeAPT0dAAAAAPCljx56lXk_CKtjvRrjxe1eImXU";
$numRows = 0;

$verify_recaptcha_response = file_get_contents('https://www.google.com/recaptcha/api/siteverify?secret=' . $recaptcha_secret_key . '&response=' . $recaptcha_response);
$recaptcha_response_data = json_decode($verify_recaptcha_response);

if ($recaptcha_response_data -> success) {
    // password hash algorithm
    $password = hash('sha512', $password);

    // Create a prepared statement
    $stmt1 = $conn -> stmt_init();
    $stmt2 = $conn -> stmt_init();
    $stmt3 = $conn -> stmt_init();
    $stmt4 = $conn -> stmt_init();
    $stmt5 = $conn -> stmt_init();

    if ($stmt1 -> prepare("SELECT account_auth_id FROM `account_auths` WHERE user_email = ? AND password = ?;")) {
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
                $_SESSION['account_auth_id'] = $row['account_auth_id'];
            }

            if ($stmt2 -> prepare(
            "SELECT is_deleted 
            FROM `account_information` 
            WHERE account_auth_id = ? 
            AND is_deleted = 0;")) {
            
                // Bind parameters
                $stmt2 -> bind_param("s", $_SESSION['account_auth_id']);

                // Execute query
                $stmt2 -> execute();
                
                // Fetch values
                $result = $stmt2 -> get_result();
                $numRows = $result -> num_rows;
                if ($numRows == 0) {
                    echo "This Account Doesn't Exist";
                    session_destroy();
                }

                // Close statement
                $stmt2 -> close();

            } else {
                echo "Query Error (sign-in.php stmt2->prepare) : $stmt2->errno : $stmt2->error   ";
            }

            if ($stmt3 -> prepare(
            "SELECT admin_id 
            FROM `account_information` 
            WHERE account_auth_id = ? 
            AND user_id = 0;")) {
            
                // Bind parameters
                $stmt3 -> bind_param("s", $_SESSION['account_auth_id']);

                // Execute query
                $stmt3 -> execute();
                
                // Fetch values
                $result = $stmt3 -> get_result();
                $numRows = $result -> num_rows;
                if ($numRows == 0) {
                    echo "This Account Doesn't Match Here";
                    session_destroy();
                } else {

                    if ($stmt4 -> prepare(
                        "SELECT account_information.account_id, 
                        accounts.account_name, 
                        account_information.account_role_id, 
                        account_roles.is_admin, account_roles.is_user, 
                        account_information.account_auth_id, 
                        account_auths.user_email, 
                        account_information.email, 
                        account_information.r_email, 
                        account_information.cellphone_number, 
                        account_information.admin_id, 
                        admins_departments.dept_id, 
                        departments.dept_name 
                        FROM `account_information`
                        INNER JOIN `accounts` ON account_information.account_id = accounts.account_id 
                        INNER JOIN `account_roles` ON account_information.account_role_id = account_roles.account_role_id 
                        INNER JOIN `account_auths` ON account_information.account_auth_id = account_auths.account_auth_id 
                        INNER JOIN `admins_departments` ON account_information.admin_id = admins_departments.admin_id 
                        INNER JOIN `departments` ON admins_departments.dept_id = departments.dept_id 
                        WHERE account_information.account_auth_id = ?;")) {
                        
                        // Bind parameters
                        $stmt4 -> bind_param("s", $_SESSION['account_auth_id']);
                    
                        // Execute query
                        $stmt4 -> execute();
                        
                        // Fetch values
                        $result = $stmt4 -> get_result();
                        while($row = $result -> fetch_assoc()){
                            $_SESSION['account_id'] = $row['account_id'];
                            $_SESSION['account_name'] = $row['account_name'];
                            $_SESSION['email'] = $row['email'];
                            $_SESSION['r_email'] = $row['r_email'];
                            $_SESSION['cellphone_number'] = $row['cellphone_number'];
                            $_SESSION['admin_id'] = $row['admin_id'];
                            $_SESSION['dept_id'] = $row['dept_id'];
                            $_SESSION['dept_name'] = $row['dept_name'];
                        }
                    
                        // Close statement
                        $stmt4 -> close();
                
                    } else {
                        echo "Query Error (sign-in.php stmt4->prepare) : $stmt4->errno : $stmt4->error";
                    }
                
                    if ($stmt5 -> prepare(
                        "UPDATE `account_information` 
                        SET active = 1 
                        WHERE account_id = ?;")) {
                        
                        // Bind parameters
                        $stmt5 -> bind_param("s", $_SESSION['account_id']);
                    
                        // Execute query
                        $stmt5 -> execute();
                    
                        // Close statement
                        $stmt5 -> close();
                
                        echo "success";

                    } else {
                        echo "Query Error (sign-in.php stmt5->prepare) : $stmt5->errno : $stmt5->error";
                    }

                }

                // Close statement
                $stmt3 -> close();

            } else {
                echo "Query Error (sign-in.php stmt3->prepare) : $stmt3->errno : $stmt3->error   ";
            }
        
        } else {
            echo "Invalid Email/Password! Contact Main Administrator or Developer to recover your account.";
        }

        // Close statement
        $stmt1 -> close();
    } else {
        echo "Query Error (sign-in.php stmt1->prepare) : $stmt1->errno : $stmt1->error";
    }

    $_SESSION['transaction_id'] = 0;
    $_SESSION['dept_svc_opt'] = false;
} else {
    echo "Failed to Verify Recaptcha";
}

$conn -> close();

?>