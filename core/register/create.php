<?php
	session_start();

	if(isset($_SESSION['user'])) {
		header("Location: /index.php");
		die();	
	}

	$email = $_POST['email'];
	$phone = $_POST['phone'];
	$password = $_POST['password'];
	$dsn ="mysql:host=localhost;dbname=equipment_rental;charset=utf8";
	$pdo = new PDO($dsn, 'root', '', array(PDO::ATTR_DEFAULT_FETCH_MODE => PDO::FETCH_ASSOC, PDO::ATTR_EMULATE_PREPARES => false));

	if($email == '' || $phone == '' || $password == '') {
		$_SESSION['register-error'] = "You must enter all fields.";
		header("Location: /register/register.php");
		die();
	} else {
		if(!filter_var($email, FILTER_VALIDATE_EMAIL)) {
			$_SESSION['register-error'] = "You must enter your email in the correct format.";
			header("Location: /register/register.php");
			die();
		} else {
			$stmt = $pdo->prepare("SELECT * FROM users WHERE email = ? LIMIT 1");
			$stmt->execute([$email]);
			$user = $stmt->fetch();

			if($user) {
			    $_SESSION['register-error'] = "This email already exists.";
			    header("Location: /register/register.php");
			    die();
			}
		}

		$phone = preg_replace('/\D/', '', substr($phone, 3));

		if(!preg_match('/^\d{9}$/', $phone)) {
			$_SESSION['register-error'] = 'Phone number must be in this format 999999999!';
			header("Location: /register/register.php");
			die();
		}

		if(mb_strlen($password) > 7 && mb_strlen($password) < 255) {
			$password = password_hash($password, PASSWORD_DEFAULT);
		} else {
			$_SESSION['register-error'] = 'Password must be min 8 and max 255 chars';
			header("Location: /register/register.php");
			die();	
		}

		$stmt = $pdo->prepare("INSERT INTO users(email, phone_number, user_password, is_admin) VALUES(?, ?, ?, ?)");
		$stmt->execute([$email, $phone, $password, 0]);
		$new_user_id = $pdo->lastInsertId();
		$user = $pdo->query("SELECT * FROM users WHERE id = $new_user_id LIMIT 1");
		$user = $user->fetch();
		$_SESSION['user'] = [
			"id" => $user['id'],
			"email" => $user['email'],
			"phone_number" => $user['phone_number'],
			"is_admin" => $user['is_admin']
		];

		header("Location: /index.php");
		die();	
	}

?>