<?php
	session_start();
	$dsn ="mysql:host=localhost;dbname=equipment_rental;charset=utf8";
	$pdo = new PDO($dsn, 'root', '', array(PDO::ATTR_DEFAULT_FETCH_MODE => PDO::FETCH_ASSOC, PDO::ATTR_EMULATE_PREPARES => false));

	$stmt = $pdo->query("SELECT equipments.id, equipments.title, equipments.description, equipments.price, photos.image FROM equipments JOIN (SELECT MIN(id) AS min_photo_id, equipment_id FROM photos GROUP BY equipment_id) AS min_photos ON equipments.id = min_photos.equipment_id JOIN photos ON min_photos.min_photo_id = photos.id WHERE equipments.is_active = 1 ORDER BY id DESC ");
	$equipments = $stmt->fetchAll();
?>
<!DOCTYPE html>
<html lang="pl">
<head>
	<meta charset="UTF-8">
	<meta name="viewport" content="width=device-width, initial-scale=1.0">
	<meta name="author" content="Dmytro Makarov">
	<title>Sport to zdrowie: home główna</title>
	<link rel="stylesheet" href="assets/css/fonts.css">
	<link rel="stylesheet" href="assets/css/variables.css">
	<link rel="stylesheet" href="assets/css/main.css">
	<link rel="stylesheet" href="assets/css/header.css">
	<link rel="stylesheet" href="assets/css/home.css">
	<script defer src="/assets/js/jquery-3.7.1.min.js"></script>
	<script defer src="/assets/js/jquery.maskedinput.min.js"></script>
	<script defer src="/assets/js/main.js"></script>
</head>
<body>
	<div class="page-wrapper">
		<?php require_once('layouts/header.php'); ?>
		<div class="page-content">
			<div class="container">
				<h1>
					Welcome to our site. Here you can rent sports equipment in any quantity!
				</h1>
				<?php if(isset($_SESSION['order-success'])) { ?>
					<div class="success"><?= $_SESSION['order-success'] ?></div>
				<?php } 
					unset($_SESSION['order-success']); 
				?>
				<div class="equipments">
					<?php if( count($equipments) > 0) { 
						foreach($equipments as $equipment) { ?>
							<a href="equipment/show.php?id=<?= $equipment['id'] ?>" class="equipment">
								<div class="equipment__image">
									<img src="assets/images/<?= $equipment['image'] ?>" alt="">
								</div>
								<h3 class="equipment__title">
									<?= $equipment['title'] ?>
								</h3>
								<div class="equipment__desc">
									<?= $equipment['description'] ?>
								</div>
								<div class="equipment__price">
									<?= $equipment['price'] ?> PLN
								</div>
							</a>
						<?php }
					} ?>
				</div>
			</div>
		</div>
	</div>
</body>
</html>