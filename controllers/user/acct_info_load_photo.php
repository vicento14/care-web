<?php

include('../database/config.php');

$result_array = array();
$result_array['data'] = array();
$result_array['success'] = 1;
$result_array['message'] = "";

$account_id = ($conn -> real_escape_string($_POST['account_id'])) ? $conn -> real_escape_string($_POST['account_id']) : $result_array['success'] = 0;
$account_photo_filename = "";
$account_photo_url = "";

if ($result_array['success'] != 0) {

    // Create a prepared statement
    $stmt1 = $conn -> stmt_init();

    if ($stmt1 -> prepare("
    SELECT account_photo_filename, 
    account_photo_url
    FROM `accounts` 
    WHERE account_id = ?;")) {
        // Bind parameters
        $stmt1 -> bind_param("s", $account_id);

        // Execute query
        $stmt1 -> execute();

        // Fetch values
        $result = $stmt1 -> get_result();
        $numRows = $result -> num_rows;
        if ($numRows > 0) {

            while($row = $result -> fetch_assoc()){
                $index['account_photo_filename'] = $row['account_photo_filename'];
                $index['account_photo_url'] = $row['account_photo_url'];
            }

            if ($index['account_photo_filename'] == ""){
                $result_array['success'] = 0;
                $result_array['message'] = "No Profile Picture";
            }

            array_push($result_array['data'], $index);

        } else {
            $result_array['success'] = 0;
            $result_array['message'] = "Not Found";
        }

        // Close statement
        $stmt1 -> close();

    } else {
        $result_array['success'] = 0;
        $result_array['message'] .= "Query Error (acct_info_change_photo.php stmt1->prepare) : $stmt1->errno : $stmt1->error";
    }

} else {
    $result_array['message'] .= "Please fill out the blank fields ";
}

if ($result_array['success'] != 0) {
    $result_array['success'] = 1;
    $result_array['message'] = "Success";
}

echo json_encode($result_array, JSON_UNESCAPED_SLASHES);

$conn -> close();

?>