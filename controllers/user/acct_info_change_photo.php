<?php

include('../database/config.php');

$result_array = array();
$result_array['success'] = 1;
$result_array['message'] = "";

$user_id = ($conn -> real_escape_string($_POST['user_id'])) ? $conn -> real_escape_string($_POST['user_id']) : $result_array['success'] = 0;
$account_id = ($conn -> real_escape_string($_POST['account_id'])) ? $conn -> real_escape_string($_POST['account_id']) : $result_array['success'] = 0;

$account_photo = $_FILES['account_photo']['tmp_name'];
$account_photo_filename = $_FILES['account_photo']['name'];
$account_photo_url = "https://careappsoftware.ml/controllers/user/uploads/";
$old_account_photo_filename = "";

if (!isset($account_photo_filename)) {
    $result_array['success'] = 0;
}

if ($result_array['success'] != 0) {

    // Create a prepared statement
    $stmt1 = $conn -> stmt_init();
    $stmt2 = $conn -> stmt_init();

    //Upload File
    $starting_dir = "./uploads/";
    $ending_dir = $user_id . "/" . rawurlencode(basename($account_photo_filename));
    $target_dir = $starting_dir;
    $target_dir .= $user_id . "/";
    $account_photo_url .= $ending_dir;
    $target_file = $target_dir . basename($account_photo_filename);
    $uploadOk = 1;

    // Check if file exist
    if (file_exists($target_file)) {
        $result_array['success'] = 0;
        $result_array['message'] .= "File Exist.  ";
        $uploadOk = 0;
    }

    // Check file size
    if ($_FILES["account_photo"]["size"] > 25000000) {
        $result_array['success'] = 0;
        $result_array['message'] .= "File was too large.  ";
        $uploadOk = 0;
    }

    if ($stmt1 -> prepare("
    SELECT account_photo_filename 
    FROM `accounts` 
    WHERE account_id = ?;")) {
        // Bind parameters
        $stmt1 -> bind_param("s", $account_id);

        // Execute query
        $stmt1 -> execute();

        // Fetch values
        $result = $stmt1 -> get_result();
        while($row = $result -> fetch_assoc()){
            $old_account_photo_filename = $row['account_photo_filename'];
        }

        // Close statement
        $stmt1 -> close();

    } else {
        $result_array['success'] = 0;
        $result_array['message'] .= "Query Error (acct_info_change_photo.php stmt1->prepare) : $stmt1->errno : $stmt1->error";
    }

    $old_target_file = $target_dir . basename($old_account_photo_filename);

    if ($old_account_photo_filename != "" && $uploadOk != 0) {
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
        echo "Sorry, your file was not uploaded. ";
    // if everything is ok, try to upload file
    } else {
        if (move_uploaded_file($account_photo, $target_file)) {
            $result_array['message'] .= "The file " . htmlspecialchars(basename($account_photo_filename)) . " has been uploaded. ";
            chmod($target_file, 0644);
        } else {
            $result_array['success'] = 0;
            $result_array['message'] .= "Upload Failed.  ";
            $uploadOk = 0;
        }
    }

    if ($uploadOk != 0) {
        if ($stmt2 -> prepare("
        UPDATE `accounts`
        SET account_photo_filename = ?, 
        account_photo_url = ? 
        WHERE account_id = ?;")) {
            // Bind parameters
            $stmt2 -> bind_param("sss", $account_photo_filename, $account_photo_url, $account_id);

            // Execute query
            $stmt2 -> execute();

            // Close statement
            $stmt2 -> close();

        } else {
            $result_array['success'] = 0;
            $result_array['message'] .= "Query Error (acct_info_change_photo.php stmt2->prepare) : $stmt2->errno : $stmt2->error";
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