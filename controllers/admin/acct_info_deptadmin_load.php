<?php

include('../database/config.php');

$data = "";

$result = $conn->query("
SELECT account_information.account_id, 
accounts.account_name, 
account_information.account_role_id, 
account_roles.is_admin, account_roles.is_user, 
account_information.account_auth_id, 
account_auths.user_email, 
account_information.admin_id, 
admins_departments.dept_id, 
departments.dept_name
FROM `account_information` 
INNER JOIN `accounts` ON account_information.account_id = accounts.account_id 
INNER JOIN `account_roles` ON account_information.account_role_id = account_roles.account_role_id 
INNER JOIN `account_auths` ON account_information.account_auth_id = account_auths.account_auth_id 
INNER JOIN `admins_departments` ON account_information.admin_id = admins_departments.admin_id 
INNER JOIN `departments` ON admins_departments.dept_id = departments.dept_id 
WHERE account_information.user_id = '' 
AND admins_departments.dept_id != 0
AND is_deleted = 0;") or die ("Query Error (acct_info_deptadmin_load.php conn->query) :".mysqli_error($conn));

$data = $result->fetch_all(MYSQLI_ASSOC);

echo json_encode($data, JSON_UNESCAPED_UNICODE);

$conn->close();

?>