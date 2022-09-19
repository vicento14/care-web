<?php
include('../database/config.php');

$data = "<option value=''>Select Department</option>";

$result = $conn->query("
SELECT * FROM `departments` WHERE dept_id != 0;") or die ("Query Error (dept_dropdown.php conn->query) :".mysqli_error($conn));

while($row = $result -> fetch_assoc()){
    $data .= "<option value='{$row['dept_id']}'>{$row['dept_name']}</option>";
}

echo $data;

$conn->close();

?>