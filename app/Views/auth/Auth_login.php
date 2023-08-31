<!DOCTYPE html>
<html lang="en">

<head>
	<title>Login</title>

	<meta charset="UTF-8">
	<meta http-equiv="X-UA-Compatible" content="IE=edge">
	<meta name="viewport" content="width=device-width, initial-scale=1.0">

	<link rel="stylesheet" href="<?= base_url('/'); ?>css/style-login.css">

	<link rel="preconnect" href="https://fonts.googleapis.com">
	<link rel="preconnect" href="https://fonts.gstatic.com" crossorigin>
	<link href="https://fonts.googleapis.com/css2?family=Montserrat:wght@400;500;700&display=swap" rel="stylesheet">
</head>

<body>
	<!-- header -->

	<header>
		<h1>SELAMAT DATANG DI WEB</h1>
		<h1>UNIVERSITAS MUHAMMADIYAH JEMBER</h1>
	</header>

	<!-- end header -->

	<!-- content -->

	<div class="content">
		<div class="container">
			<div class="login">

				<form action="" method="post" class="formkontener">
					<h3>GUNAKAN USERNAME DAN PASSWORD SESUAI SIA</h3>
					<hr>
					<?= csrf_field() ?>
					<label for="">USERNAME</label>

					<input type="text" name="dataLogin" placeholder="login" required>
					<label for="">PASSWORD</label>

					<input type="password" name="dataPassword" placeholder="password" required>
					<input type="submit" value="MASUK">
				</form>

			</div>
			<div class="image">
				<img src="<?= base_url('/'); ?>asset/logo/unmuh.png" alt="">
			</div>
		</div>
	</div>

	<!-- end content -->
</body>

</html>