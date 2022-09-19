<?php

include('../database/config.php');

$account_id = ($conn -> real_escape_string($_POST['account_id'])) ? $conn -> real_escape_string($_POST['account_id']) : '';
$account_auth_id = 0;
$user_id = 0;

date_default_timezone_set("Asia/Manila");
$date_verified = date('Y-m-d H:i:s');

$old_valid_id_filename = "";

$response_msg = "";

// Create a prepared statement
$stmt1 = $conn -> stmt_init();
$stmt2 = $conn -> stmt_init();
$stmt3 = $conn -> stmt_init();

if ($stmt1 -> prepare("
SELECT account_auth_id, user_id
FROM `account_information` 
WHERE account_id = ?")) {
    // Bind parameters
    $stmt1 -> bind_param("s", $account_id);

    // Execute query
    $stmt1 -> execute();

    // Fetch values
    $result = $stmt1 -> get_result();
    while($row = $result -> fetch_assoc()){
        $account_auth_id = $row['account_auth_id'];
        $user_id = $row['user_id'];
    }

    // Close statement
    $stmt1 -> close();

    $response_msg = "success";

} else {
    echo "Query Error (acct_info_resident_reject.php stmt1->prepare) : $stmt1->errno : $stmt1->error";
    $response_msg = "failed";
}

if ($response_msg != "failed") {

    //Upload File
    $target_dir = "../user/uploads/" . $user_id . "/";
    $uploadOk = 1;

    if ($stmt2 -> prepare("
    SELECT valid_id_filename 
    FROM `account_auths` 
    WHERE account_auth_id = ?;")) {
        // Bind parameters
        $stmt2 -> bind_param("s", $account_auth_id);

        // Execute query
        $stmt2 -> execute();

        // Fetch values
        $result = $stmt2 -> get_result();
        while($row = $result -> fetch_assoc()){
            $old_valid_id_filename = $row['valid_id_filename'];
        }

        // Close statement
        $stmt2 -> close();

    } else {
        $response_msg = "failed";
        echo "Query Error (acct_info_resident_reject.php stmt2->prepare) : $stmt2->errno : $stmt2->error";
    }

    $old_target_file = $target_dir . basename($old_valid_id_filename);

    if ($old_valid_id_filename != "" && $uploadOk != 0) {
        if (file_exists($old_target_file)) {
            if (!unlink($old_target_file)) { 
                $response_msg = "failed";
                echo "File Cannot Be Replaced.  "; 
                $uploadOk = 0;
            }
        }
    }

    if ($uploadOk != 0) {
        if ($stmt3 -> prepare("
        UPDATE `account_auths` 
        SET valid_id_filename = '', valid_id_url = '', date_verified = ?
        WHERE account_auth_id = ?;")) {
            // Bind parameters
            $stmt3 -> bind_param("ss", $date_verified, $account_auth_id);

            // Execute query
            $stmt3 -> execute();

            // Close statement
            $stmt3 -> close();

        } else {
            $response_msg = "failed";
            echo "Query Error (acct_info_resident_reject.php stmt3->prepare) : $stmt3->errno : $stmt3->error";
        }
    }

} else {
    echo "account_id not found. ";
}

$conn -> close();

?>