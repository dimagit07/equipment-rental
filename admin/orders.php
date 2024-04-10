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

	$stmt = $pdo->query("SELECT * FROM `orders`");
	$orders = $stmt->fetchAll();
?>

<!DOCTYPE html>
<html lang="pl">
<head>
	<meta charset="UTF-8">
	<meta name="viewport" content="width=device-width, initial-scale=1.0">
	<meta name="author" content="Dmytro Makarov">
	<title>Sport to zdrowie: Orders</title>
	<link rel="stylesheet" href="/assets/css/fonts.css">
	<link rel="stylesheet" href="/assets/css/variables.css">
	<link rel="stylesheet" href="/assets/css/main.css">
	<link rel="stylesheet" href="/assets/css/header.css">
	<link rel="stylesheet" href="/assets/css/orders.css">
	<script defer src="/assets/js/jquery-3.7.1.min.js"></script>
	<script defer src="/assets/js/main.js"></script>
	<script defer src="/assets/js/orders.js"></script>
</head>
<body>
	<div class="page-wrapper">
		<?php require_once('../layouts/header.php'); ?>
		<div class="page-content">
			<div class="container">
				<div class="orders">
					<div class="container">
						<div class="orders__inner">
							<div class="title">
								List of orders
							</div>
							<div class="order__list">
								<?php foreach($orders as $order) { ?>
									<div class="order">
										<a href="../equipment/show.php?id=<?= $order['equipment_id'] ?>" class="order__title">
											<span>(<?= $order['id'] ?>)</span>
										</a>
										<div class="order__info">
											<div class="order__row">
												Count - <?= $order['count'] ?>
											</div>
											<div class="order__row">
												Price - <?= $order['price'] ?>
											</div>
											<div class="order__row">
												Comment:<br>
												<?= $order['comment'] ?>
											</div>
										</div>
										<div class="order__current-status">Current status - 
											<?php
												switch ($order['status']) {
													case 1:
														echo 'Created';
														break;
													
													case 2:
														echo 'Confirmed';
														break;

													case 3:
														echo 'Completed';
														break;

													case 4:
														echo 'Rejected';
														break;
												}
											?>
										</div>
										<div class="order__statuses">
											<div class="order__status order__status_warning" data-order="<?= $order['id'] ?>" data-status="2">
												Confirmed
											</div>
											<div class="order__status order__status_green" data-order="<?= $order['id'] ?>" data-status="3">
												Completed
											</div>
											<div class="order__status order__status_red" data-order="<?= $order['id'] ?>" data-status="4">
												Rejected
											</div>
										</div>
									</div>
								<?php } ?>
							</div>
						</div>
					</div>
				</div>
			</div>
		</div>
	</div>
</body>
</html>