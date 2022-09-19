<?php

include('../database/config.php');

$data = "";

$result = $conn->query("SELECT * FROM `barangays`;") or die ("Query Error (brgy_load.php conn->query) :".mysqli_error($conn));

$data = $result->fetch_all(MYSQLI_ASSOC);

echo json_encode($data, JSON_UNESCAPED_UNICODE);

$conn->close();

?>