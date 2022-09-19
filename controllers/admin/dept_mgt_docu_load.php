<?php

include('../database/config.php');

session_start();

$dept_id = $_SESSION['dept_id'];
$dept_docu_set_id = "";
$data = "";

// Create a prepared statement
$stmt1 = $conn -> stmt_init();

if ($stmt1 -> prepare("
SELECT dept_id, dept_docu_set_id
FROM `department_information`
WHERE dept_id = ?;")) {
  // Bind parameters
  $stmt1 -> bind_param("s", $dept_id);

  // Execute query
  $stmt1 -> execute();

  // Fetch values
  $result = $stmt1 -> get_result();
  while($row = $result -> fetch_assoc()){
    $dept_docu_set_id = $row['dept_docu_set_id'];
  }

  // Close statement
  $stmt1 -> close();
} else {
  echo "Query Error (dept_mgt_docu_load.php stmt1->prepare) : $stmt1->errno : $stmt1->error";
}

$result = $conn->query("
SELECT dept_docu_id, dept_docu_name, dept_docu_filename 
FROM `department_documents`
WHERE dept_docu_set_id = '$dept_docu_set_id';") 
or die ("Query Error (dept_mgt_docu_load.php conn->query) :".mysqli_error($conn));

$data = $result->fetch_all(MYSQLI_ASSOC);

echo json_encode($data, JSON_UNESCAPED_UNICODE);

$conn->close();

?>