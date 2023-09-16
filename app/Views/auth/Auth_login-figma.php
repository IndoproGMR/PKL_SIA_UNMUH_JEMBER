<!DOCTYPE html>
<html lang="en">

<head>
	<title>Login</title>

	<meta charset="UTF-8">
	<meta http-equiv="X-UA-Compatible" content="IE=edge">
	<meta name="viewport" content="width=device-width, initial-scale=1.0">

	<!-- <link rel="stylesheet" href="<?= base_url('/css/style-login.css'); ?>"> -->

	<link rel="preconnect" href="https://fonts.googleapis.com">
	<link rel="preconnect" href="https://fonts.gstatic.com" crossorigin>
	<link href="https://fonts.googleapis.com/css2?family=Montserrat:wght@400;500;700&display=swap" rel="stylesheet">
</head>

<style>
	* {
		margin: 0;
		padding: 0;
		box-sizing: border-box;
		font-family: "Montserrat", sans-serif;
	}

	body {
		background-color: #f5f5f5;
	}

	header {
		text-align: center;
		margin-top: 30px;
	}

	h3 {
		text-align: center;
		font-size: 20px;
		font-weight: bold;
		margin-bottom: 10px;
	}

	form label {
		/* display: block; */
		font-size: 20px;
		font-weight: 600;
		/* padding: 5px; */
		/* margin-bottom: 50px; */
	}

	::-webkit-input-placeholder {
		/* Chrome/Opera/Safari */
		color: #a1a1a1;
	}

	::-moz-placeholder {
		/* Firefox 19+ */
		color: #a1a1a1;
	}

	input {
		width: 100%;
		margin: 2px;
		border: none;
		outline: none;
		padding: 8px;
		border-radius: 10px;
		border: 1px solid rgba(0, 0, 0, 0.4);
		background: #b9ddff;
		color: #000;
	}

	input[type="submit"] {
		width: 80%;

		border: none;
		outline: none;
		padding: 8px;
		color: black;
		font-size: 20px;
		font-weight: 700;
		cursor: pointer;
		/* bottom: 10px; */
		margin-top: 20px;
		/* margin-bottom: 20px; */
		border-radius: 20px;
		background: #5e98d0;
	}

	input[type="submit"]:hover {
		background: #6fbae1;
	}

	form {
		display: grid;
		align-items: center;
		justify-content: center;
		padding: 50px;
	}

	.tombol-submit>input {
		display: block;
		margin-right: auto;
		margin-left: auto;
	}

	.formkontener {
		/* width: 600px; */
		height: 400px;

		/* background-color: #e1f0ff; */
		padding: 20px;
		border-radius: 20px;
		/* box-shadow: 0 5px 5px rgba(0, 0, 0, 0.1); */
	}

	.login-page {
		display: flex;
		/* justify-content: center; */
		align-items: center;
		margin-top: 30px;

		/* background-color: red; */
	}

	.login-form {
		/* height: 400px; */


		margin-left: 60px;
		background-color: #e1f0ff;

		/* padding: 20px; */
		/* margin: 20px; */

		/* background-color: green; */
		border-radius: 20px;

		box-shadow: 0 10px 15px rgba(0, 0, 0, 0.3);
	}

	.gambar-kotak-pos {
		/* padding: 20px; */
		width: 100%;
		display: flex;
		justify-content: center;
		align-items: center;
		/* background-color: green; */
	}

	.gambar-kotak-pos>img {
		width: 450px;
		/* margin: auto; */
		/* background-color: green; */
		box-shadow: 0 0 50px 50px #f5f5f5 inset;
		/* box-shadow: 0 0 50px 50px #f00 inset; */
	}

	@media only screen and (max-width: 600px) {
		.login-form {
			/* height: 400px; */

			margin: 20px;

			/* margin-left: 60px; */
			background-color: #e1f0ff;

			/* padding: 20px; */
			/* margin: 20px; */

			/* background-color: green; */

		}

		.gambar-kotak-pos>img {
			display: none;
		}
	}
</style>

<body>
	<!-- header -->

	<header>
		<h1>SELAMAT DATANG DI WEB</h1>
		<h1>UNIVERSITAS MUHAMMADIYAH JEMBER</h1>
	</header>

	<!-- end header -->

	<!-- content -->


	<div class="login-page">
		<div class="login-form">
			<form action="" method="post" class="formkontener">
				<h3>GUNAKAN USERNAME DAN PASSWORD SESUAI SIA</h3>
				<hr>
				<?= csrf_field() ?>
				<div class="input-kontener">
					<label for="dataLogin">USERNAME</label>
					<input id="dataLogin" type="text" name="dataLogin" placeholder="login" required>
				</div>

				<div class="input-kontener">
					<label for="dataPassword">PASSWORD</label>
					<input id="dataPassword" type="password" name="dataPassword" placeholder="password" required>
				</div>

				<div class="tombol-submit">
					<input type="submit" value="MASUK">
				</div>
			</form>
		</div>

		<div class="gambar-kotak-pos">
			<img src="asset/svg/gambar-kotak-pos.svg" alt="" srcset="" class="gambar-pos">
		</div>
	</div>

	<!-- end content -->

</body>

</html>