<?php 

include('../database/config.php');

$result_array = array();
$result_array['success'] = 1;
$result_array['message'] = "";
$result_array['data'] = array();

$user_id = ($conn -> real_escape_string($_POST['user_id'])) ? $conn -> real_escape_string($_POST['user_id']) : $result_array['success'] = 0;
$is_rated = 0;

if ($result_array['success'] != 0) {

    // Create a prepared statement
    $stmt1 = $conn -> stmt_init();

    if ($stmt1 -> prepare(
        "SELECT user_id FROM `app_ratings` WHERE user_id = ?")) {

        // Bind parameters
        $stmt1 -> bind_param("s", $user_id);

        // Execute query
        $stmt1 -> execute();

        // Fetch values
        $result = $stmt1 -> get_result();
        $numRows = $result -> num_rows;
        if ($numRows > 0) {
            $is_rated = 1;
        } else {
            $is_rated = 0;
        }

        // Close statement
        $stmt1 -> close();

    } else {
        $result_array['success'] = 0;
        $result_array['message'] .= "Query Error (app_rating_insert.php stmt1->prepare) : $stmt1->errno : $stmt1->error";
    }

    $index['is_rated'] = $is_rated;
    array_push($result_array['data'], $index);

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