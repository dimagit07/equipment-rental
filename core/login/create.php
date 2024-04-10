<?php
	session_start();

	if(isset($_SESSION['user'])) {
		header("Location: /index.php");
		die();	
	}

	$email = $_POST['email'];
	$password = $_POST['password'];
	$dsn ="mysql:host=localhost;dbname=equipment_rental;charset=utf8";
	$pdo = new PDO($dsn, 'root', '', array(PDO::ATTR_DEFAULT_FETCH_MODE => PDO::FETCH_ASSOC, PDO::ATTR_EMULATE_PREPARES => false));

	if($email == '' || $password == '') {
		$_SESSION['login-error'] = "You must enter all fields.";
		header("Location: /login/login.php");
		die();
	} else {
		if(!filter_var($email, FILTER_VALIDATE_EMAIL)) {
			$_SESSION['login-error'] = "You must enter your email in the correct format.";
			header("Location: /login/login.php");
			die();
		} else {
			$stmt = $pdo->prepare("SELECT * FROM users WHERE email = ? LIMIT 1");
			$stmt->execute([$email]);
			$user = $stmt->fetch();

			if(!$user) {
			    $_SESSION['login-error'] = "Wrong login or password.";
			    header("Location: /login/login.php");
			    die();
			}

			if(!password_verify($password, $user['user_password'])) {
				$_SESSION['login-error'] = "Wrong login or password.";
				header("Location: /login/login.php");
				die();
			}

			$_SESSION['user'] = [
				"id" => $user['id'],
				"email" => $user['email'],
				"phone_number" => $user['phone_number'],
				"is_admin" => $user['is_admin']
			];

			header("Location: /index.php");
			die();
		}
	}
?>