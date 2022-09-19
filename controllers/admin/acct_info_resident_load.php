<?php

include('../database/config.php');

$data = array();
$is_verified = 0;
$verification_status = "";

// Create a prepared statement
$stmt1 = $conn -> stmt_init();

if ($stmt1 -> prepare("
SELECT account_information.account_id, 
accounts.account_name, 
account_information.account_role_id, 
account_roles.is_admin, account_roles.is_user, 
account_information.account_auth_id, 
account_auths.user_email, 
account_auths.valid_id_filename, 
account_auths.is_verified, 
account_information.user_id, 
account_information.barangay_id, 
barangays.barangay_name 
FROM `account_information` 
INNER JOIN `accounts` ON account_information.account_id = accounts.account_id 
INNER JOIN `account_roles` ON account_information.account_role_id = account_roles.account_role_id 
INNER JOIN `account_auths` ON account_information.account_auth_id = account_auths.account_auth_id 
INNER JOIN `barangays` ON account_information.barangay_id = barangays.barangay_id 
WHERE account_information.admin_id = ''
AND is_deleted = 0;")) {

    // Execute query
    $stmt1 -> execute();

    // Fetch values
    $result = $stmt1 -> get_result();
    while($row = $result -> fetch_assoc()){
        $is_verified = $row['is_verified'];
        if ($is_verified != 0) {
            $verification_status = "Verified";
        } else if ($row['valid_id_filename'] != "") {
            $verification_status = "Need Verification";
        } else {
            $verification_status = "Not Verified";
        }
        $index['account_id'] = $row['account_id'];
        $index['user_id'] = $row['user_id'];
        $index['account_name'] = $row['account_name'];
        $index['user_email'] = $row['user_email'];
        $index['barangay_id'] = $row['barangay_id'];
        $index['barangay_name'] = $row['barangay_name'];
        $index['verification_status'] = $verification_status;
        array_push($data, $index);
    }

    // Close statement
    $stmt1 -> close();

} else {
    echo "Query Error (acct_info_resident_load.php stmt1->prepare) : $stmt1->errno : $stmt1->error";
}

echo json_encode($data, JSON_UNESCAPED_UNICODE);

$conn->close();

?>