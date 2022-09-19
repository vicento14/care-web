<?php

include('../database/config.php');

session_start();

$code = ($conn -> real_escape_string($_POST['code'])) ? $conn -> real_escape_string($_POST['code']) : '';
intval($code);
$success = 0;

if ($code == $_SESSION['code']) {
    $success = 1;
}

echo $success;

?>