<?php

include('../database/config.php');

$result_array = array();
$result_array['success'] = 1;
$result_array['message'] = "";

$notif_id = ($conn -> real_escape_string($_POST['notif_id'])) ? $conn -> real_escape_string($_POST['notif_id']) : $result_array['success'] = 0;

date_default_timezone_set("Asia/Manila");
$is_deleted_date = date('Y-m-d H:i:s');

if ($result_array['success'] != 0) {

    // Create a prepared statement
    $stmt1 = $conn -> stmt_init();

    if ($stmt1 -> prepare(
        "UPDATE `cms_notif_info`
        SET is_deleted = 1, is_deleted_date = ?
        WHERE notif_id = ?;")) {
        // Bind parameters
        $stmt1 -> bind_param("ss", $is_deleted_date, $notif_id);

        // Execute query
        $stmt1 -> execute();

        // Close statement
        $stmt1 -> close();
    } else {
        $result_array['success'] = 0;
        $result_array['message'] .= "Query Error (brgy_delete.php stmt1->prepare) : $stmt1->errno : $stmt1->error";
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