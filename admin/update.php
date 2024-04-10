<?php
session_start();
$dsn ="mysql:host=localhost;dbname=equipment_rental;charset=utf8";
$pdo = new PDO($dsn, 'root', '', array(PDO::ATTR_DEFAULT_FETCH_MODE => PDO::FETCH_ASSOC, PDO::ATTR_EMULATE_PREPARES => false));

if(!isset($_SESSION['user'])) {
	header("Location: /index.php");
	die();	
}
if( $_SESSION['user']['is_admin'] != 1 ) {
	header("Location: /index.php");
	die();	
}

$allowed_value = [2, 3, 4];
$order_id = $_POST['order_id'];
$status = $_POST['status'];

if(in_array($status, $allowed_value)) {
	$stmt = $pdo->prepare("SELECT * FROM `orders` WHERE id = ? LIMIT 1");
	$stmt->execute([$order_id]);
	$order = $stmt->fetch();

	if($order) {
		$stmt = $pdo->prepare("UPDATE `orders` SET `status` = ? WHERE id = ?");
		$stmt->execute([$status, $order_id]);
		$response = ["status" => true, "message" => "Ok!"];
		echo json_encode($response, JSON_UNESCAPED_UNICODE | JSON_UNESCAPED_SLASHES);
	} else {
		$response = ["status" => false, "message" => "No!"];
		echo json_encode($response, JSON_UNESCAPED_UNICODE | JSON_UNESCAPED_SLASHES);
	}
} else {
	$response = ["status" => false, "message" => "No!"];
	echo json_encode($response, JSON_UNESCAPED_UNICODE | JSON_UNESCAPED_SLASHES);
}