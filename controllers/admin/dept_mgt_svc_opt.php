<?php
include('../database/config.php');

session_start();

$dept_svc_opt = ($conn -> real_escape_string($_POST['dept_svc_opt'])) ? $conn -> real_escape_string($_POST['dept_svc_opt']) : '';

if (isset($_SESSION['dept_svc_opt'])) {
	unset($_SESSION['dept_svc_opt']);
}

$_SESSION['dept_svc_opt'] = $dept_svc_opt;
?>