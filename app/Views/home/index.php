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
</style>
<?= $this->endSection() ?>

<?= $this->section('main') ?>

<div class="card">
  <h1>Selamat Datang <?= esc(userInfo()['NamaUser']) ?>, Di Web Surat Universitas Muhammadiyah Jember</h1>
</div>

<?= $this->endSection() ?>