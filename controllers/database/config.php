<?php
	$host = 'sql204.epizy.com';
	$user = 'epiz_29536041';
	$password = 'EKwibkSKo7';
	$database = 'epiz_29536041_care_db';
	$port = 3306;

	$conn = mysqli_connect($host, $user, $password, $database, $port);

	// Check connection
	if (mysqli_connect_errno()) {
		echo "Failed to connect to MySQL: " . mysqli_connect_error();
	}
?>