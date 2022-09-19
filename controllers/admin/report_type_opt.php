<?php
include('../database/config.php');

session_start();

$transaction_id = ($conn -> real_escape_string($_POST['transaction_id'])) ? $conn -> real_escape_string($_POST['transaction_id']) : '';

if (isset($_SESSION['transaction_id'])) {
	unset($_SESSION['transaction_id']);
}

$_SESSION['transaction_id'] = $transaction_id;
?>