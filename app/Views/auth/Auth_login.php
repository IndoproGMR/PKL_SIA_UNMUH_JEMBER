<?= $this->extend('templates/layout.php') ?>

<?= $this->section('main') ?>
<div class="container">
	<div class="row justify-content-center mt-5">
		<div class="col-md-4">
			<br>
			<div class="card">
				<h5 class="text-center" style="margin-top: 50px;">
					Form <span class="font-weight-bold text-primary">LOGIN</span>
				</h5>
				<div class="card-body">
					<form action="../home/index.php" method="POST">
						<div class="form-group">
							<input type="text" name="username" class="form-control" placeholder="Username" required="required">
						</div>
						<div class="form-group">
							<input type="password" name="password" class="form-control" placeholder="Password" required="required">
						</div>
						<div class="form-group custom-control custom-checkbox">
							<input type="checkbox" class="custom-control-input" id="customControlAutosizing">
							<label class="custom-control-label" for="customControlAutosizing">Remember me</label>
							<a href="#" class="float-right" style="text-decoration: none;">Lupa Password?</a>
						</div>
						<div class="form-group">
							<input type="submit" name="submit" class="btn btn-primary btn-block" value="Login">

						</div>
					</form>
				</div>
			</div>
			<p class="text-center">
				Belum Punya Akun ?<span class="font-weight-bold text-primary">
					<a href="../register/index.php" style="text-decoration: none;">Daftar Disini</a></span>
			</p>
		</div>
	</div>
</div>


<?= $this->endSection() ?>