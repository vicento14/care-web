<?php

include('../database/config.php');

$result_array = array();
$result_array['data'] = array();
$result_array['success'] = 1;
$result_array['message'] = "";

$dept_id = ($conn -> real_escape_string($_POST['dept_id'])) ? $conn -> real_escape_string($_POST['dept_id']) : $result_array['success'] = 0;
$dept_docu_set_id = "";

if ($result_array['success'] != 0) {

    // Create a prepared statement
    $stmt1 = $conn -> stmt_init();

    if ($stmt1 -> prepare(
    "SELECT dept_id, dept_docu_set_id
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
        $result_array['success'] = 0;
        $result_array['message'] .= "Query Error (dept_mgt_docu_load.php stmt1->prepare) : $stmt1->errno : $stmt1->error";
    }

    $result = $conn->query(
    "SELECT dept_docu_id, dept_docu_name, 
    dept_docu_filename, dept_docu_url 
    FROM `department_documents`
    WHERE dept_docu_set_id = '$dept_docu_set_id';") 
    or die ("Query Error (dept_mgt_docu_load.php conn->query) :".mysqli_error($conn));

    $numRows = $result -> num_rows;
    if ($numRows > 0) {
        $result_array['data'] = $result->fetch_all(MYSQLI_ASSOC);
    } else {
        $result_array['success'] = 0;
        $result_array['message'] = "Not Found";
    }

} else {
    $result_array['message'] .= "Please fill out the blank fields";
}

if ($result_array['success'] != 0) {
    $result_array['success'] = 1;
    $result_array['message'] = "Success";
}

echo json_encode($result_array, JSON_UNESCAPED_SLASHES);

$conn->close();

?>