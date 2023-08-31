<?= $this->extend('templates/layout.php') ?>

<?= $this->section('style') ?>
<link rel="stylesheet" href="<?= base_url('/'); ?>css/status.css">
<?= $this->endSection() ?>

<?= $this->section('main') ?>


<div>
    <p>mahasiswa yang buat: <span><?= esc($namaMHS); ?></span></p>
    <p>kapan Surat Dibuat: <span><?= esc(timeconverter($TimeStamp)) ?></span></p>
    <p>Jenis Surat: <span><?= esc($name); ?></span></p>
</div>


<form action="<?= base_url('/Staff/Edit-proses/Permintaan_TTD-Surat_Tanpa_NoSurat'); ?>" method="post">
    <?= csrf_field() ?>
    <input type="hidden" name="id" value="<?= esc($id); ?>">
    <br>
    <label for="DiskripsiSurat">NoSurat Surat:</label>
    <input type="text" name="NoSurat">
    <br>
    <input type="submit" value="Update">
</form>


<br>
<hr>
<br>

<?= view_cell('TombolIdCell', [
    'link'              => 'staff/Preview-Surat',
    'valueinput'        => $id,
    'tombolsubmitclass' => 'signature',
    'textsubmit'        => 'Preview Surat',
    'confirmdialog'     => false,
    'target'            => '_blank'
]) ?>


<?= view_cell('TombolIdCell', [
    'link'              => 'delete-proses/surat-tanpa_NoSurat',
    'valueinput'        => $id,
    'tombolsubmitclass' => 'signature',
    'textsubmit'        => 'Delete Surat',
    'confirmdialog'     => true,
    'target'            => '_self'
]) ?>




<?= $this->endSection() ?>