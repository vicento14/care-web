<?php
include('../database/config.php');

$result_array = array();
$result_array['data'] = array();
$result_array['success'] = 1;
$result_array['message'] = "";

$result = $conn->query("SELECT * FROM `departments` WHERE dept_id != 0;") or die ("Query Error (dept_dropdown.php conn->query) :".mysqli_error($conn));

$numRows = $result -> num_rows;
if ($numRows > 0) {
    $result_array['data'] = $result->fetch_all(MYSQLI_ASSOC);
} else {
    $result_array['success'] = 0;
    $result_array['message'] .= "No Departments";
}

if ($result_array['success'] != 0) {
    $result_array['success'] = 1;
    $result_array['message'] = "Success";
}

echo json_encode($result_array);

$conn->close();

?>