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
	<title>Sport to zdrowie: login</title>
	<link rel="stylesheet" href="/assets/css/fonts.css">
	<link rel="stylesheet" href="/assets/css/variables.css">
	<link rel="stylesheet" href="/assets/css/main.css">
	<link rel="stylesheet" href="/assets/css/header.css">
	<link rel="stylesheet" href="/assets/css/login.css">
</head>
<body>
	<div class="page-wrapper">
		<?php require_once('../layouts/header.php'); ?>
		<div class="page-content">
			<div class="container">
				<div class="login">
					<div class="container">
						<div class="login__inner">
							<div class="title">
								Login
							</div>
							<form class="form" action="../core/login/create.php" method="POST">
								<?php if(isset($_SESSION['login-error'])) { ?>
									<div class="fail"><?= $_SESSION['login-error'] ?></div>
								<?php } 
									unset($_SESSION['login-error']); 
								?>
								<div class="form__row">
									<label for="email">
										Email
									</label>
									<input type="email" name="email" id="email">
								</div>
								<div class="form__row">
									<label for="password">
										Password
									</label>
									<input type="password" name="password" value="" id="password">
								</div>
								<div class="form__btn">
									<button type="submit">Login</button>
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