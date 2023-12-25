<?= $this->extend('templates/layout.php') ?>
<?= $this->section('main') ?>

<h1>Kop Surat</h1>

<form class="inputform" action="<?= base_url('/Admin-Panel/Upload-proses/Upload-KopSurat'); ?>" method="post" enctype="multipart/form-data" method="post" accept-charset="utf-8">
    <?= csrf_field() ?>
    <div>
        <label for="SiapaYangMembuat">Siapa Yang Membuat</label>
        <input type="text" name="SiapaYangMembuat" id="SiapaYangMembuat">
    </div>
    <div>
        <label for="FileKop">File Kop surat</label>
        <input type="file" name="FileKop" id="FileKop">
    </div>
    <input type="submit" value="Upload Kop Surat">
</form>

<?= $this->endSection() ?>