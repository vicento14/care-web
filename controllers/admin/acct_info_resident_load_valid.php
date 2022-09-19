<?php
include('../database/config.php');

$account_id = ($conn -> real_escape_string($_POST['account_id'])) ? $conn -> real_escape_string($_POST['account_id']) : '';
$account_auth_id = 0;

$data = "";
$has_valid_id = 0;
$is_verified = 0;
$response_array = array();

// Create a prepared statement
$stmt1 = $conn -> stmt_init();
$stmt2 = $conn -> stmt_init();

if ($stmt1 -> prepare("
SELECT account_auth_id
FROM `account_information` 
WHERE account_id = ?")) {
    // Bind parameters
    $stmt1 -> bind_param("s", $account_id);

    // Execute query
    $stmt1 -> execute();

    // Fetch values
    $result = $stmt1 -> get_result();
    while($row = $result -> fetch_assoc()){
        $account_auth_id = $row['account_auth_id'];
    }

    // Close statement
    $stmt1 -> close();

    $response_msg = "success";

} else {
    echo "Query Error (acct_info_resident_load_valid.php stmt1->prepare) : $stmt1->errno : $stmt1->error";
    $response_msg = "failed";
}

if ($response_msg != "failed") {
    if ($stmt2 -> prepare("
    SELECT valid_id_filename, valid_id_url, is_verified
    FROM `account_auths` 
    WHERE account_auth_id = ?;")) {
        // Bind parameters
        $stmt2 -> bind_param("s", $account_auth_id);

        // Execute query
        $stmt2 -> execute();

        // Fetch values
        $result = $stmt2 -> get_result();
        while($row = $result -> fetch_assoc()){
            $is_verified = intval($row['is_verified']);
            if ($row['valid_id_filename'] != "") {
                $data .= "<div class='col-sm-6'>
                <div class='card'>
                <div class='card-body'>
                <h5 class='card-title'>{$row['valid_id_filename']}</h5>
                <p class='card-text'>Valid ID Photo</p>
                <a href='{$row['valid_id_url']}' target='_blank' class='btn btn-success'><Small>View Valid ID</Small></a>
                </div>
                </div>
                </div>";
                $has_valid_id = 1;
            } else {
                $data .= "<div class='col-sm-6'>
                <div class='card'>
                <div class='card-body'>
                <h5 class='card-title'>No Valid ID Uploaded</h5>
                </div>
                </div>
                </div>";
                $has_valid_id = 0;
            }
        }

        // Close statement
        $stmt2 -> close();

        $response_msg = "success";

        $response_array = array(
            'data' => $data, 
            'has_valid_id' => $has_valid_id, 
            'is_verified' => $is_verified
        );
        
        echo json_encode($response_array, JSON_FORCE_OBJECT);

    } else {
        echo "Query Error (acct_info_resident_load_valid.php stmt2->prepare) : $stmt2->errno : $stmt2->error";
        $response_msg = "failed";
    }
} else {
    echo "account_id not found. ";
}

$conn -> close();

?>