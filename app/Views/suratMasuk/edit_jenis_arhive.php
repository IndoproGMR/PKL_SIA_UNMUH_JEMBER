<?= $this->extend('templates/layout.php') ?>

<?= $this->section('style') ?>
<link rel="stylesheet" href="<?= base_url('/css/tablestyle.css'); ?>">
<?= $this->endSection() ?>

<?= $this->section('main') ?>
<form class="inputform" action="<?= base_url('/staff/edit-proses/JenisSurat'); ?>" method="post">
    <?= csrf_field() ?>
    <input type="hidden" name="id" id="id" value="<?= esc($surat['id']) ?>">
    <div>
        <label for="Name">Nama Jenis Surat:</label>
        <input type="text" name="Name" id="Name" value="<?= esc($surat['name']) ?>">
    </div>

    <div>
        <label for="DiskripsiJenis">Deskripsi Jenis Surat:</label>
        <input type="text" name="DiskripsiJenis" id="DiskripsiJenis" value="<?= esc($surat['description']) ?>">
    </div>
    <br>
    <input type="submit" value="Simpan">
</form>

<p>total yang surat yang terpakai: <span><?= esc($count['countSurat']) ?></span></p>

<?php
$text = "menghapus jenis surat ini akan mengubah: " . $count['countSurat'] . " surat!!";


?>
<?= view_cell('TombolIdCell', [
    'link'              => 'staff/delete-proses/JenisSurat',
    'valueinput'        => $surat['id'],
    'tombolsubmitclass' => 'Actions danger',
    'textsubmit'        => 'Delete jenis Surat',
    'confirmdialog'     => true,
    'textConfirm'       => $text,
    'target'            => '_self'
]) ?>

<?= $this->endSection() ?>