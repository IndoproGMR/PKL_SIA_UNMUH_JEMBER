<?= $this->extend('templates/layout.php') ?>

<?= $this->section('main') ?>

<div class="container">
	<div class="row justify-content-center mt-5">
		<div class="col-md-4">
			<div class="card">
				<div class="card-header bg-transparent mb-0">
					<h5 class="text-center">Form <span class="font-weight-bold text-primary">REGISTER</span></h5>
				</div>
				<div class="card-body">
					<form action="#" method="POST">
						<div class="form-group">
							<input type="text" name="username" class="form-control" placeholder="Username" required="required">
						</div>
						<div class="form-group">
							<input type="email" name="email" class="form-control" placeholder="E-mail" required="required">
						</div>
						<div class="form-group">
							<input type="password" name="password" class="form-control" placeholder="Password" required="required">
						</div>
						<div class="form-group custom-control custom-checkbox">
							<input type="checkbox" class="custom-control-input" id="customControlAutosizing">
							<label class="custom-control-label" for="customControlAutosizing">Remember me</label>
						</div>
						<div class="form-group">
							<input type="submit" name="daftar" class="btn btn-primary btn-block" value="Daftar">
						</div>
					</form>
				</div>
			</div>
			<p class="text-center">
				Sudah Punya Akun ? <span class="font-weight-bold text-primary">
					<a href="../login/index.php" style="text-decoration: none;">Login Disini</a></span>
			</p>
		</div>
	</div>
</div>
<?= $this->endSection() ?>