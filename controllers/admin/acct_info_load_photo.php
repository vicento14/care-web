<?php

include('../database/config.php');

session_start();

$admin_id = $_SESSION['admin_id'];
$account_id = $_SESSION['account_id'];
$account_photo_filename = "";
$account_photo_url = "";

$data = "";

// Create a prepared statement
$stmt1 = $conn -> stmt_init();

if ($stmt1 -> prepare("
SELECT account_photo_filename, 
account_photo_url
FROM `accounts` 
WHERE account_id = ?;")) {
    // Bind parameters
    $stmt1 -> bind_param("s", $account_id);

    // Execute query
    $stmt1 -> execute();

    // Fetch values
    $result = $stmt1 -> get_result();
    while($row = $result -> fetch_assoc()){
        $account_photo_filename = $row['account_photo_filename'];
        $account_photo_url = $row['account_photo_url'];
    }

    // Close statement
    $stmt1 -> close();

} else {
    echo "Query Error (acct_info_change_photo.php stmt1->prepare) : $stmt1->errno : $stmt1->error";
}

if ($account_photo_filename != ""){
    $data .= "<img id='account_photo' src='{$account_photo_url}' alt='Your account photo' style='height: 150px; width:auto;' class='p-3 rounded-circle' />";
} else {
    $data .= "<img id='account_photo' src='../assets/img/noimage_person.png' alt='Your account photo' style='height: 150px; width:auto;' class='p-3 rounded-circle' />";
}

echo $data;

$conn -> close();

?>