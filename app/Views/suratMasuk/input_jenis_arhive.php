<?= $this->extend('templates/layout.php') ?>

<?= $this->section('style') ?>
<link rel="stylesheet" href="<?= base_url('/'); ?>css/status.css">
<?= $this->endSection() ?>

<?= $this->section('main') ?>

<form action="/input-jenis-arhive-surat" id="inputJenisSurat" style="display: none;">
    <input type="submit" value="Tambah Jenis Surat">
</form>
<br>
<br>
<form action="" method="post">
    <?= csrf_field() ?>

    <div>
        <label for="Name">Nama Jenis Surat:</label>
        <input type="text" name="Name" id="Name">
    </div>

    <div>
        <label for="DiskripsiJenis">Deskripsi Jenis Surat:</label>
        <input type="text" name="DiskripsiJenis" id="DiskripsiJenis">
    </div>

    <input type="submit" value="Simpan">
</form>

<?php foreach ($jenisFilter as $value) : ?>
    <p><?= esc($value['name']) ?></p>
    <p><?= esc($value['description']) ?></p>
<?php endforeach ?>


<?= $this->endSection() ?>



<?= $this->section('jsF') ?>
<script>
    function cek() {
        var idjenis = document.getElementById('jenissuratid').value;
        var formElement = document.getElementById('inputJenisSurat');
        if (idjenis !== '---') {
            formElement.style.display = 'none'; // Menyembunyikan form
        } else {
            formElement.style.display = 'block'; // Menampilkan form
        }
    }
</script>
<?= $this->endSection() ?>