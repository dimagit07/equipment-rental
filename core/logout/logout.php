<?php
	session_start();

	if(!isset($_SESSION['user'])) {
		header("Location: /index.php");
		die();	
	}

	unset($_SESSION['user']);
	$response = ["status" => true];
	echo json_encode($response, JSON_UNESCAPED_UNICODE | JSON_UNESCAPED_SLASHES);
?>