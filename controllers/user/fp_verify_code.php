<?php

include('../database/config.php');

session_start();

$result_array = array();
$result_array['success'] = 1;
$result_array['message'] = "";

$code = ($conn -> real_escape_string($_POST['code'])) ? $conn -> real_escape_string($_POST['code']) : $result_array['success'] = 0;

if ($result_array['success'] != 0) {

    intval($code);

    if ($code == $_SESSION['code']) {
        $result_array['success'] = 1;
        $result_array['message'] = "Success";
    } else {
        $result_array['success'] = 0;
        $result_array['message'] = "Incorrect Code";
    }

} else {
    $result_array['message'] .= "Please fill out the blank fields ";
}

echo json_encode($result_array);

?>