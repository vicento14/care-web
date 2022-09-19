<?php
session_start();

if(!isset($_SESSION['account_auth_id'])){
	header('location:https://careappsoftware.ml/admin/index.php');
}
?>