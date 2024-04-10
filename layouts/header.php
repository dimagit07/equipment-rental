<header class="header">
	<div class="container">
		<div class="header__inner">
			<a href="../index.php" class="logo">
				SPORT TO ZDROWIE
			</a>
			<nav class="menu">
				<?php if(!isset($_SESSION['user'])) { ?>
				<a href="../login/login.php" class="menu__item">
					Login
				</a>
				<a href="../register/register.php" class="menu__item">
					Register
				</a>
				<?php } ?>
				<?php if(isset($_SESSION['user'])) { ?>
				<div class="menu__item logout-js">
					Logout
				</div>
				<?php } ?>
			</nav>
		</div>
	</div>
</header>