<?php
	session_start();

	if(isset($_SESSION['user'])) {
		header("Location: /index.php");
		die();	
	}
?>
<!DOCTYPE html>
<html lang="pl">
<head>
	<meta charset="UTF-8">
	<meta name="viewport" content="width=device-width, initial-scale=1.0">
	<meta name="author" content="Dmytro Makarov">
	<title>Sport to zdrowie: registration</title>
	<link rel="stylesheet" href="/assets/css/fonts.css">
	<link rel="stylesheet" href="/assets/css/variables.css">
	<link rel="stylesheet" href="/assets/css/main.css">
	<link rel="stylesheet" href="/assets/css/header.css">
	<link rel="stylesheet" href="/assets/css/register.css">
	<script defer src="/assets/js/jquery-3.7.1.min.js"></script>
	<script defer src="/assets/js/jquery.maskedinput.min.js"></script>
	<script defer src="/assets/js/main.js"></script>
	<script defer src="/assets/js/register.js"></script>
</head>
<body>
	<div class="page-wrapper">
		<?php require_once('../layouts/header.php'); ?>
		<div class="page-content">
			<div class="container">
				<div class="register">
					<div class="container">
						<div class="register__inner">
							<div class="title">
								Registration 
							</div>
							<form class="form" action="../core/register/create.php" method="POST">
								<?php if(isset($_SESSION['register-error'])) { ?>
									<div class="fail"><?= $_SESSION['register-error'] ?></div>
								<?php } 
									unset($_SESSION['register-error']); 
								?>
								<div class="form__row">
									<label for="email">
										Email
									</label>
									<input type="email" name="email" id="email">
								</div>
								<div class="form__row">
									<label for="phone">
										Phone number
									</label>
									<input type="text" name="phone" id="phone" class="phone-js">
								</div>
								<div class="form__row">
									<label for="phone">
										Password
									</label>
									<input type="password" name="password" id="password">
								</div>
								<div class="form__btn">
									<button type="submit">Register</button>
								</div>
							</form>
						</div>
					</div>
				</div>
			</div>
		</div>
	</div>
</body>
</html>