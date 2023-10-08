<?php
$ci = env('CI_ENVIRONMENT');
$auth = env('AUTH_ENVIRONMENT');
?>


<?= $this->extend('templates/layout.php') ?>
<?= $this->section('style') ?>
<!-- masukan style nya -->
<style>
  .card {
    margin: 50px;
  }

  .card h1 {
    text-align: center;
  }

  .konten-kontener {
    background-color: grey;
    border-radius: 10px;
    padding: 10px;
  }
</style>
<?= $this->endSection() ?>

<?= $this->section('main') ?>

<div class="card">
  <h1>Selamat Datang <?= esc(userInfo()['NamaUser']) ?>, Di Web Surat Universitas Muhammadiyah Jember</h1>
</div>

<div class="konten-kontener">




  <?php if ($ci == 'development') : ?>
    <div style="color: red;">
      <h2>CI_ENVIRONMENT: <span><?= esc($ci) ?></span></h2>
    </div>
  <?php endif ?>
  <br>

  <?php if ($auth == 'development') : ?>
    <div style="color: red;">
      <h2>AUTH_ENVIRONMENT: <span><?= esc($auth) ?></span></h2>
    </div>
  <?php endif ?>

</div>

<?= $this->endSection() ?>