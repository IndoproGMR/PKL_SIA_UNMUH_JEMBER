<?= $this->extend('templates/layout.php') ?>
<?= $this->section('style') ?>
<?= $this->endSection() ?>

<?= $this->section('main') ?>
<form class="inputform" action="<?= base_url('/Update-Proses/BlackList-Mahasiswa'); ?>" method="post">
    <?= csrf_field() ?>
    <input type="hidden" name="id" value="<?= esc($id); ?>">

    <p>Nama Mahasiswa : <span><?= esc($namaMHS); ?></span></p>

    <br>
    <div>
        <label for="diskripsi">Kenapa Mahasiswa Di BlackList ?</label>
        <br>
        <textarea name="diskripsi" id="diskripsi"></textarea>
    </div>
    <input type="submit" value="Masukan Mahasiswa Ke BlackList" id="tombolUpdate" class="Actions danger">
</form>
<?= $this->endSection() ?>