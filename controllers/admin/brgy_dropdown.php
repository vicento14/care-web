<?php
include('../database/config.php');

$data = "<option value=''>Select Barangay</option>";

$result = $conn->query("SELECT * FROM `barangays`;") or die ("Query Error (brgy_dropdown.php conn->query) :".mysqli_error($conn));

while($row = $result -> fetch_assoc()){
    $data .= "<option value='{$row['barangay_id']}'>{$row['barangay_name']}</option>";
}

echo $data;

$conn->close();

?>