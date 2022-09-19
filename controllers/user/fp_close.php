<?php

$result_array = array();
$result_array['success'] = 1;
$result_array['message'] = "";

session_start();

session_destroy();

if ($result_array['success'] != 0) {
    $result_array['success'] = 1;
    $result_array['message'] = "Success";
}

echo json_encode($result_array);

?>