<?php
include('../database/config.php');

$transaction_id = ($conn -> real_escape_string($_POST['transaction_id'])) ? $conn -> real_escape_string($_POST['transaction_id']) : '';
$user_id = 0;
$upload_set_id = 0;

$data = "";

// Create a prepared statement
$stmt1 = $conn -> stmt_init();
$stmt2 = $conn -> stmt_init();

if ($stmt1 -> prepare("
SELECT transaction_id, 
user_id, upload_set_id 
FROM `assistance_transactions` 
WHERE transaction_id = ?")) {
    // Bind parameters
    $stmt1 -> bind_param("s", $transaction_id);

    // Execute query
    $stmt1 -> execute();

    // Fetch values
    $result = $stmt1 -> get_result();
    while($row = $result -> fetch_assoc()){
        $user_id = $row['user_id'];
        $upload_set_id = $row['upload_set_id'];
    }

    // Close statement
    $stmt1 -> close();

    $response_msg = "success";

} else {
    echo "Query Error (report_response_view.php stmt1->prepare) : $stmt1->errno : $stmt1->error";
    $response_msg = "failed";
}

if ($response_msg != "failed") {
    if ($stmt2 -> prepare("
    SELECT * 
    FROM `uploads` 
    WHERE upload_set_id = ?;")) {
        // Bind parameters
        $stmt2 -> bind_param("s", $upload_set_id);

        // Execute query
        $stmt2 -> execute();

        // Fetch values
        $result = $stmt2 -> get_result();
        $numRows = $result -> num_rows;
        if ($numRows > 0) {
            while($row = $result -> fetch_assoc()){
                $data .= "<div class='col-sm-3'>
                <div class='card'>
                <div class='card-body'>
                <h5 class='card-title'>{$row['upload_filename']}</h5>
                <p class='card-text'>File</p>
                <a href='{$row['upload_url']}' class='btn btn-success'><Small>Download</Small></a>
                </div>
                </div>
                </div>";
            }
        } else {
            $data .= "<div class='col-sm-3'>
            <div class='card'>
            <div class='card-body'>
            <h5 class='card-title'>No files uploaded</h5>
            </div>
            </div>
            </div>";
        }

        // Close statement
        $stmt2 -> close();

        $response_msg = "success";

        echo $data;

    } else {
        echo "Query Error (report_response_view.php stmt2->prepare) : $stmt2->errno : $stmt2->error";
        $response_msg = "failed";
    }
} else {
    echo "transaction_id not found. ";
}

$conn -> close();

?>