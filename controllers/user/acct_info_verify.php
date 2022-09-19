<?php

include('../database/config.php');

$result_array = array();
$result_array['success'] = 1;
$result_array['message'] = "";
$result_array['data'] = array();

$user_id = ($conn -> real_escape_string($_POST['user_id'])) ? $conn -> real_escape_string($_POST['user_id']) : $result_array['success'] = 0;
$account_auth_id = 0;

$valid_id = $_FILES['valid_id']['tmp_name'];
$valid_id_filename = $_FILES['valid_id']['name'];
$valid_id_filetype = $_FILES['valid_id']['type'];
$valid_id_url = "https://careappsoftware.ml/controllers/user/uploads/";
$old_valid_id_filename = "";

if (!isset($_FILES['valid_id']['name'])) {
    $result_array['success'] = 0;
}

if ($result_array['success'] != 0) {

    // Create a prepared statement
    $stmt1 = $conn -> stmt_init();
    $stmt2 = $conn -> stmt_init();
    $stmt3 = $conn -> stmt_init();

    //Upload File
    $starting_dir = "./uploads/";
    $ending_dir = $user_id . "/" . rawurlencode(basename($valid_id_filename));
    $target_dir = $starting_dir;
    $target_dir .= $user_id . "/";
    $valid_id_url .= $ending_dir;
    $target_file = $target_dir . basename($valid_id_filename);
    $uploadOk = 1;

    // Check if file exist
    if (file_exists($target_file)) {
        $result_array['success'] = 0;
        $result_array['message'] .= "File Exist.  ";
        $uploadOk = 0;
    }

    // Check file size
    if ($_FILES["valid_id"]["size"] > 25000000) {
        $result_array['success'] = 0;
        $result_array['message'] .= "File was too large.  ";
        $uploadOk = 0;
    }

    if ($stmt1 -> prepare("
    SELECT account_auth_id
    FROM `account_information` 
    WHERE user_id = ?")) {
        // Bind parameters
        $stmt1 -> bind_param("s", $user_id);

        // Execute query
        $stmt1 -> execute();

        // Fetch values
        $result = $stmt1 -> get_result();
        while($row = $result -> fetch_assoc()){
            $account_auth_id = $row['account_auth_id'];
        }

        // Close statement
        $stmt1 -> close();

    } else {
        $result_array['success'] = 0;
        $result_array['message'] .= "Query Error (acct_info_verify.php stmt1->prepare) : $stmt1->errno : $stmt1->error";
    }

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
        $result_array['success'] = 0;
        $result_array['message'] .= "Query Error (acct_info_verify.php stmt2->prepare) : $stmt2->errno : $stmt2->error";
    }

    $old_target_file = $target_dir . basename($old_valid_id_filename);

    if ($old_valid_id_filename != "" && $uploadOk != 0) {
        if (file_exists($old_target_file)) {
            if (!unlink($old_target_file)) { 
                $result_array['success'] = 0;
                $result_array['message'] .= "File Cannot Be Replaced.  "; 
                $uploadOk = 0;
            }
        }
    }

    // Check if $uploadOk is set to 0 by an error
    if ($uploadOk == 0) {
        $result_array['success'] = 0;
        $result_array['message'] .= "Sorry, your file was not uploaded. ";
    // if everything is ok, try to upload file
    } else {
        if (move_uploaded_file($valid_id, $target_file)) {
            $result_array['message'] .= "The file " . htmlspecialchars(basename($valid_id_filename)) . " has been uploaded. ";
            chmod($target_file, 0644);
        } else {
            $result_array['success'] = 0;
            $result_array['message'] .= "Upload Failed.  ";
            $uploadOk = 0;
        }
    }

    if ($uploadOk != 0) {

        if ($stmt3 -> prepare("
        UPDATE `account_auths` 
        SET valid_id_filename = ?, valid_id_url = ? 
        WHERE account_auth_id = ?;")) {
            // Bind parameters
            $stmt3 -> bind_param("sss", $valid_id_filename, $valid_id_url, $account_auth_id);

            // Execute query
            $stmt3 -> execute();

            // Close statement
            $stmt3 -> close();

        } else {
            $result_array['success'] = 0;
            $result_array['message'] .= "Query Error (acct_info_verify.php stmt3->prepare) : $stmt3->errno : $stmt3->error";
        }

    }

} else {
    $result_array['message'] .= "Please fill out the blank fields ";
}

if ($result_array['success'] != 0) {
    $result_array['success'] = 1;
    $result_array['message'] = "Success";

    $index['verification_status'] = "2";
    array_push($result_array['data'], $index);
}

echo json_encode($result_array);

$conn -> close();

?>