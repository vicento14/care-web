<?php
function acct_create_folder($folder_name, $folder_role) {
    include('../database/config.php');

    $admin_output_dir = "./uploads/profilepictures/";
    $user_output_dir = "../user/uploads/";
    $output_dir = "";
    $success = 0;

    if ($folder_role == 0) {
        $output_dir = $admin_output_dir;
    } else {
        $output_dir = $user_output_dir;
    }

    if (!file_exists($output_dir . $folder_name)){
        @mkdir($output_dir . $folder_name, 0755);/* Create folder by using mkdir function */
        //"Folder Created"
        $success = 1;
    } else {
        //"Folder exist, no changes were made"
        $success = 0;
    }

    return $success;
}
?>