<?php
session_start();

if(!isset($_SESSION['user'])) {
	header("Location: ../../login/login.php");
	die();	
}

$dsn ="mysql:host=localhost;dbname=equipment_rental;charset=utf8";
$pdo = new PDO($dsn, 'root', '', array(PDO::ATTR_DEFAULT_FETCH_MODE => PDO::FETCH_ASSOC, PDO::ATTR_EMULATE_PREPARES => false));

$id = $_POST['id'];
$comment = htmlspecialchars($_POST['comment'], ENT_QUOTES);
$amount = $_POST['amount'];

$stmt = $pdo->prepare("SELECT * FROM `equipments` WHERE `id` = ? LIMIT 1");
$stmt->execute(array($id));
$equipment = $stmt->fetch();

if(!$equipment) {
	header("Location: ../../index.php");
	die();	
}

if( !isset($comment) || $comment == '' || mb_strlen($comment) < 25) {
	$_SESSION['order-error'] = "You must fill in the comment field. Min 25 characters";
	header("Location: ../../equipment/show.php?id={$id}");
	die();
}

if( !isset($amount) || $amount == '' || $amount < 1) {
	$_SESSION['order-error'] = "You must fill in the amount field. Min 1 item";
	header("Location: ../../equipment/show.php?id={$id}");
	die();
}

$total_price = $amount * $equipment['price'];

$stmt = $pdo->prepare("INSERT INTO orders(equipment_id, user_id, count, price, comment, status) VALUES(?, ?, ?, ?, ?, ?)");
$stmt->execute([$equipment['id'], $_SESSION['user']['id'], $amount, $total_price, $comment, 1]);

$_SESSION['order-success'] = "The order has been successfully created. Wait for a call from our manager";
header("Location: ../../index.php");
die();