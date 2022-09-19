<?php

include('../database/config.php');

$admin_output_dir = "./uploads/profilepictures/";
$user_output_dir = "../user/uploads/";
$output_dir = "";

$folder_name = $_POST['folder_name'];
$folder_role = $_POST['folder_role'];

if ($folder_role == 0) {
    $output_dir = $admin_output_dir;
} else {
    $output_dir = $user_output_dir;
}

if (!file_exists($output_dir . $folder_name)){
    @mkdir($output_dir . $folder_name, 0777);/* Create folder by using mkdir function */
    echo "Folder Created";
} else {
    echo "Folder exist, no changes were made";
}

?>