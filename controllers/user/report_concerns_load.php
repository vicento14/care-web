<?php

include('../database/config.php');

$result_array = array();
$result_array['data'] = array();
$result_array['success'] = 1;
$result_array['message'] = "";

$user_id = ($conn -> real_escape_string($_POST['user_id'])) ? $conn -> real_escape_string($_POST['user_id']) : $result_array['success'] = 0;

if ($result_array['success'] != 0) {

    // Create a prepared statement
    $stmt1 = $conn -> stmt_init();

    if ($stmt1 -> prepare("
    SELECT assistance_transactions.transaction_end_date,
    assistance_transactions.transaction_id, 
    assistance_transactions.report_id, 
    reports.report_name, 
    reports.report_details, 
    assistance_transactions.dept_id, 
    departments.dept_name, 
    assistance_transactions.admin_id 
    FROM `assistance_transactions` 
    INNER JOIN `reports` ON assistance_transactions.report_id = reports.report_id 
    INNER JOIN `departments` ON assistance_transactions.dept_id = departments.dept_id 
    WHERE assistance_transactions.report_type_id = 1 
    AND assistance_transactions.user_id = ?;")) {
        // Bind parameters
        $stmt1 -> bind_param("s", $user_id);

        // Execute query
        $stmt1 -> execute();

        // Fetch values
        $result = $stmt1 -> get_result();
        $numRows = $result -> num_rows;
        if ($numRows > 0) {
            while($row = $result -> fetch_assoc()){
                $index['date'] = date("Y-m-d h:iA", strtotime($row['transaction_end_date']));
                $index['transaction_id'] = $row['transaction_id'];
                $index['report_id'] = $row['report_id'];
                $index['title'] = $row['report_name'];
                $index['description'] = $row['report_details'];
                $index['dept_id'] = $row['dept_id'];
                $index['dept_name'] = $row['dept_name'];
                array_push($result_array['data'], $index);
            }
        } else {
            $result_array['success'] = 0;
            $result_array['message'] = "Not Found";
        }

        // Close statement
        $stmt1 -> close();

    } else {
        $result_array['success'] = 0;
        $result_array['message'] .= "Query Error (report_concerns_load.php stmt1->prepare) : $stmt1->errno : $stmt1->error";
    }

} else {
    $result_array['message'] .= "Please fill out the blank fields";
}
    
if ($result_array['success'] != 0) {
    $result_array['success'] = 1;
    $result_array['message'] = "Success";
}

echo json_encode($result_array);

$conn->close();

?>