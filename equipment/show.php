<?php
session_start();
$dsn ="mysql:host=localhost;dbname=equipment_rental;charset=utf8";
$pdo = new PDO($dsn, 'root', '', array(PDO::ATTR_DEFAULT_FETCH_MODE => PDO::FETCH_ASSOC, PDO::ATTR_EMULATE_PREPARES => false));
$arrow = '<svg viewBox="0 0 24 24"><polygon points="7.293 4.707 14.586 12 7.293 19.293 8.707 20.707 17.414 12 8.707 3.293 7.293 4.707"/></svg>';

$id = $_GET['id'];
$stmt = $pdo->prepare("SELECT * FROM `equipments` WHERE `id` = ? LIMIT 1");
$stmt->execute(array($id));
$equipment = $stmt->fetch();

if(!$equipment) {
	header("Location: /index.php");
	die();	
}

$stmt = $pdo->query("SELECT * FROM `photos` WHERE `equipment_id` = $id");
$photos = $stmt->fetchAll();

?>

<!DOCTYPE html>
<html lang="pl">
<head>
	<meta charset="UTF-8">
	<meta name="viewport" content="width=device-width, initial-scale=1.0">
	<meta name="author" content="Dmytro Makarov">
	<title>Sport to zdrowie: <?=$equipment['title']?></title>
	<link rel="stylesheet" href="/assets/css/fonts.css">
	<link rel="stylesheet" href="/assets/css/variables.css">
	<link rel="stylesheet" href="/assets/css/main.css">
	<link rel="stylesheet" href="/assets/css/header.css">
	<link rel="stylesheet" href="/assets/css/equipment.css">
	<script defer src="/assets/js/jquery-3.7.1.min.js"></script>
	<script defer src="/assets/js/slick.min.js"></script>
	<script defer src="/assets/js/main.js"></script>
	<script defer src="/assets/js/equipment.js"></script>
</head>
<body>
	<div class="page-wrapper">
		<?php require_once('../layouts/header.php'); ?>
		<div class="page-content">
			<div class="container">
				<div class="equipment">
					<div class="container">
						<div class="equipment__innder">
							<div class="left">
								<div class="slider">
									<div class="slider__inner">
										<div class="slider__arrow slider__arrow-left">
											<?= $arrow ?>
										</div>
										<div class="slider__items">
											<?php foreach($photos as $photo) { ?>
												<div class="slider__item">
													<img src="../assets/images/<?= $photo['image'] ?>" alt="<?= $equipment['title'] ?>">
												</div>
											<?php } ?>
										</div>
										<div class="slider__arrow slider__arrow-right">
											<?= $arrow ?>
										</div>
									</div>
								</div>
							</div>
							<div class="right">
								<div class="right__top">
									<h1 class="title">
										<?= $equipment['title'] ?>
									</h1>
									<p class="description">
										<?= $equipment['description'] ?>
									</p>
									<div class="price">
										<?= $equipment['price'] ?> PLN
									</div>
								</div>
								<form class="form" method="POST" action="../core/orders/create.php">
									<?php if(isset($_SESSION['order-error'])) { ?>
										<div class="fail"><?= $_SESSION['order-error'] ?></div>
									<?php } 
										unset($_SESSION['order-error']); 
									?>
									<input type="hidden" name="id" value="<?= $equipment['id'] ?>">
									<label for="comment">Write to us your contact information (phone number and email), as well as your name and residential address.</label>
										<textarea name="comment" id="comment"></textarea>
									<div class="form__footer">
										<input type="number" data-price="<?= $equipment['price'] ?>"  min="0" max="25" name="amount" value="1">
										<button type="submit">Buy this product</button>
									</div>
								</form>
								<div class="form__total">
									Total price - <?= $equipment['price'] ?> PLN
								</div>
							</div>
						</div>
					</div>
				</div>
			</div>
		</div>
	</div>
</body>
</html>