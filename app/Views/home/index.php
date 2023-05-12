<?= $this->extend('templates/layout.php') ?>
<?= $this->section('main') ?>
<?= $this->include('templates/navbar') ?>

<div class="jumbotron" style="padding-top: 50px;">
  <div class="container">
    <h1 class="display-3">
      Project PKL
    </h1> <br>
    <p>Bisa diisi deskripsi singkat disini</p>
    <p><a class="btn btn-primary btn-lg" href="#" role="button">Selengkapnya &raquo;</a></p>
  </div>
</div>

<div class="container">

  <div class="row">

    <div class="col-md">
      <div class="card" style="width: 22rem;">
        <div class="card-body">
          <p class="card-text" style="text-align: center; font-size: 20px;">
          <h2 align="center">1</h2>
          <hr>
          </p>
          ISI STEP BY STEP
        </div>
      </div>
    </div>

    <div class="col-md" style="text-align: justify;">
      <div class="card" style="width: 20rem;">
        <div class="card-body">
          <p class="card-text" style="text-align: center; font-size: 20px;">
          <h2 align="center">2</h2>
          <hr>
          </p>
          ISI STEP BY STEP
        </div>
      </div>
    </div>

    <div class="col-md" style="text-align: justify;">
      <div class="card" style="width: 22rem;">
        <div class="card-body">
          <p class="card-text" style="text-align: center; font-size: 20px;">
          <h2 align="center">3</h2>
          <hr>
          </p>
          ISI STEP BY STEP
        </div>
      </div>
    </div>

  </div>
</div>

<hr>

<?= $this->endSection() ?>