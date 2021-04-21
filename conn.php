<?php
	$conn = new mysqli('localhost', 'root', '', 'company_ems');

	if ($conn->connect_error) {
	    die("Connection failed: " . $conn->connect_error);
	}
	
?>