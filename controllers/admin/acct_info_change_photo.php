<?php

include('../database/config.php');

session_start();

$admin_id = $_SESSION['admin_id'];
$account_id = $_SESSION['account_id'];

$account_photo = $_FILES['account_photo']['tmp_name'];
$account_photo_filename = $_FILES['account_photo']['name'];
$account_photo_url = "https://careappsoftware.ml/controllers/admin/uploads/";
$old_account_photo_filename = "";

// Create a prepared statement
$stmt1 = $conn -> stmt_init();
$stmt2 = $conn -> stmt_init();

//Upload File
$starting_dir = "./uploads/";
$ending_dir = "profilepictures/$admin_id/" . basename($account_photo_filename);
$target_dir = $starting_dir;
$target_dir .= "profilepictures/$admin_id/";
$account_photo_url .= $ending_dir;
$target_file = $target_dir . basename($account_photo_filename);
$uploadOk = 1;

// Check if file exist
if (file_exists($target_file)) {
    echo "Sorry, file already exists. ";
    $uploadOk = 0;
}

// Check file size
if ($_FILES["account_photo"]["size"] > 25000000) {
    echo "Sorry, your file is too large. ";
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
    echo "Query Error (acct_info_change_photo.php stmt1->prepare) : $stmt1->errno : $stmt1->error";
}

$old_target_file = $target_dir . basename($old_account_photo_filename);

if ($old_account_photo_filename != "" && $uploadOk != 0) {
    if (file_exists($old_target_file)) {
        if (!unlink($old_target_file)) { 
            echo ("The file called $old_account_photo_filename cannot be replaced due to an error"); 
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
        echo "The file " . htmlspecialchars(basename($account_photo_filename)) . " has been uploaded. ";
        chmod($target_file, 0644);
    } else {
        echo "Sorry, there was an error uploading your file. ";
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

        echo " Account Profile Picture Saved Successfully";

    } else {
        echo "Query Error (acct_info_change_photo.php stmt2->prepare) : $stmt2->errno : $stmt2->error";
    }
} else {
    echo " Account Profile Picture Save Failed";
}

$conn -> close();

?>