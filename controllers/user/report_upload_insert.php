<?php

include('../database/config.php');

$result_array = array();
$result_array['success'] = 1;
$result_array['message'] = "";

$user_id = ($conn -> real_escape_string($_POST['user_id'])) ? $conn -> real_escape_string($_POST['user_id']) : $result_array['success'] = 0;
$transaction_id = ($conn -> real_escape_string($_POST['transaction_id'])) ? $conn -> real_escape_string($_POST['transaction_id']) : $result_array['success'] = 0;

$upload_file = $_FILES['upload_file']['tmp_name'];
$upload_filename = $_FILES['upload_file']['name'];
$upload_filetype = $_FILES['upload_file']['type'];
$upload_url = "https://careappsoftware.ml/controllers/user/uploads/";
$old_upload_filename = "";

$upload_id = 0;
$upload_set_id = 0;
date_default_timezone_set("Asia/Manila");
$date_uploaded = date('Y-m-d H:i:s');

if (!isset($_FILES['upload_file']['name'])) {
    $result_array['success'] = 0;
}

if ($result_array['success'] != 0) {

    // Create a prepared statement
    $stmt1 = $conn -> stmt_init();
    $stmt2 = $conn -> stmt_init();
    $stmt3 = $conn -> stmt_init();
    $stmt4 = $conn -> stmt_init();

    //Upload File
    $starting_dir = "./uploads/";
    $ending_dir = $user_id . "/" . rawurlencode(basename($upload_filename));
    $target_dir = $starting_dir;
    $target_dir .= $user_id . "/";
    $upload_url .= $ending_dir;
    $target_file = $target_dir . basename($upload_filename);
    $uploadOk = 1;

    // Check if file exist
    if (file_exists($target_file)) {
        $result_array['success'] = 0;
        $result_array['message'] .= "File Exist.  ";
        $uploadOk = 0;
    }

    // Check file size
    if ($_FILES["upload_file"]["size"] > 25000000) {
        $result_array['success'] = 0;
        $result_array['message'] .= "File was too large.  ";
        $uploadOk = 0;
    }

    if ($stmt1 -> prepare("
    SELECT upload_set_id 
    FROM `assistance_transactions` 
    WHERE transaction_id = ?;")) {
        // Bind parameters
        $stmt1 -> bind_param("s", $transaction_id);

        // Execute query
        $stmt1 -> execute();

        // Fetch values
        $result = $stmt1 -> get_result();
        while($row = $result -> fetch_assoc()){
            $upload_set_id = $row['upload_set_id'];
        }

        // Close statement
        $stmt1 -> close();

    } else {
        $result_array['success'] = 0;
        $result_array['message'] .= "Query Error (report_upload_insert.php stmt1->prepare) : $stmt1->errno : $stmt1->error";
    }

    if ($stmt2 -> prepare("
    SELECT upload_filename 
    FROM `uploads` 
    WHERE upload_set_id = ?;")) {
        // Bind parameters
        $stmt2 -> bind_param("s", $upload_set_id);

        // Execute query
        $stmt2 -> execute();

        // Fetch values
        $result = $stmt2 -> get_result();
        while($row = $result -> fetch_assoc()){
            $old_upload_filename = $row['upload_filename'];
        }

        // Close statement
        $stmt2 -> close();

    } else {
        $result_array['success'] = 0;
        $result_array['message'] .= "Query Error (report_upload_insert.php stmt2->prepare) : $stmt2->errno : $stmt2->error";
    }

    $old_target_file = $target_dir . basename($old_upload_filename);

    if ($old_upload_filename != "" && $uploadOk != 0) {
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
        if (move_uploaded_file($upload_file, $target_file)) {
            $result_array['message'] .= "The file " . htmlspecialchars(basename($account_photo_filename)) . " has been uploaded. ";
            chmod($target_file, 0644);
        } else {
            $result_array['success'] = 0;
            $result_array['message'] .= "Upload Failed.  ";
            $uploadOk = 0;
        }
    }

    if ($uploadOk != 0) {

        if ($stmt3 -> prepare("SELECT upload_id FROM `uploads` ORDER BY upload_id DESC LIMIT 1;")) {
        // Execute query
        $stmt3 -> execute();
        
        // Fetch values
        $result = $stmt3 -> get_result();
        $numRows = $result -> num_rows;
        if ($numRows > 0) {
            while($row = $result -> fetch_assoc()){
                $upload_id = intval($row['upload_id']);
            }
        }
        
        // Close statement
        $stmt3 -> close();
        
        $upload_id++;
        
        } else {
            $result_array['success'] = 0;
            $result_array['message'] .= "Query Error (report_upload_insert.php stmt3->prepare) : $stmt3->errno : $stmt3->error";
        }

        if ($stmt4 -> prepare("
        INSERT INTO `uploads` (upload_id, upload_set_id, upload_filename, upload_filetype, upload_url, date_uploaded) 
        VALUES (?, ?, ?, ?, ?, ?);")) {
            // Bind parameters
            $stmt4 -> bind_param("ssssss", $upload_id, $upload_set_id, $upload_filename, $upload_filetype, $upload_url, $date_uploaded);

            // Execute query
            $stmt4 -> execute();

            // Close statement
            $stmt4 -> close();

        } else {
            $result_array['success'] = 0;
            $result_array['message'] .= "Query Error (report_upload_insert.php stmt4->prepare) : $stmt4->errno : $stmt4->error";
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