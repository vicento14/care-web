<?php

include('../database/config.php');

$data = "";

$result = $conn->query("SELECT * FROM `departments` WHERE dept_id != 0;") or die ("Query Error (dept_load.php conn->query) :".mysqli_error($conn));

$data = $result->fetch_all(MYSQLI_ASSOC);

echo json_encode($data, JSON_UNESCAPED_UNICODE);

$conn->close();

?>