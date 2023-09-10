<?= $this->extend('templates/layout.php') ?>

<?= $this->section('style') ?>
<link rel="stylesheet" href="<?= base_url('/'); ?>css/status.css">
<style>
    /* Gaya untuk kotak sukses */
    .success-box {
        background-color: #4caf50;
        color: white;
        padding: 10px;
        border-radius: 5px;
        text-align: center;
    }

    /* Gaya untuk ikon centang */
    .success-icon {
        display: inline-block;
        width: 20px;
        height: 20px;
        background-color: white;
        border-radius: 50%;
        text-align: center;
        line-height: 20px;
        margin-right: 10px;
        color: #4caf50;
    }

    /* Gaya untuk pesan sukses */
    .success-message {
        display: inline-block;
        vertical-align: middle;
    }
</style>
<?= $this->endSection() ?>

<?= $this->section('main') ?>



<form action="<?= base_url('/staff/edit-proses/JenisSurat'); ?>">
    <?= csrf_field() ?>
    <input hidden type="text" name="id" id="id" value="<?= esc($surat['id']) ?>">
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
    'tombolsubmitclass' => 'signature',
    'textsubmit'        => 'Delete jenis Surat',
    'confirmdialog'     => true,
    'textConfirm'       => $text,
    'target'            => '_self'
]) ?>

<?= $this->endSection() ?>