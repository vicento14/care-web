<?php
include('../database/config.php');

$result_array = array();
$result_array['success'] = 1;
$result_array['message'] = "";

$account_id = ($conn -> real_escape_string($_POST['account_id'])) ? $conn -> real_escape_string($_POST['account_id']) : $result_array['success'] = 0;
$cellphone_number = ($conn -> real_escape_string($_POST['cellphone_number'])) ? $conn -> real_escape_string($_POST['cellphone_number']) : $result_array['success'] = 0;

if ($result_array['success'] != 0) {

    if (preg_match("/^[0-9]{11}$/", $cellphone_number)) {

        // Create a prepared statement
        $stmt1 = $conn -> stmt_init();

        if ($stmt1 -> prepare("UPDATE `account_information` SET cellphone_number = ? WHERE account_id = ?;")) {
            // Bind parameters
            $stmt1 -> bind_param("ss", $cellphone_number, $account_id);

            // Execute query
            $stmt1 -> execute();

            // Close statement
            $stmt1 -> close();

        } else {
            $result_array['success'] = 0;
            $result_array['message'] .= "Query Error (acct_info_name.php stmt1->prepare) : $stmt1->errno : $stmt1->error";
        }

    } else {
        $result_array['success'] = 0;
        $result_array['message'] .= "Invalid Phone Number Format";
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