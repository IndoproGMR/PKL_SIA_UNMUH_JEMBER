<?= $this->extend('templates/layout.php') ?>

<?= $this->section('style') ?>
<link rel="stylesheet" href="<?= base_url('/'); ?>css/status.css">
<?= $this->endSection() ?>

<?= $this->section('main') ?>

<form action="<?= base_url('/'); ?>edit-archive-surat" method="post">
    <?= csrf_field() ?>
    <input type="hidden" name="id" value="<?= esc($id); ?>">
    <br>
    <label for="DiskripsiSurat">Deskripsi Surat:</label>
    <input type="text" name="DiskirpsiSurat" value="<?= esc($DiskirpsiSurat); ?>">
    <br>
    <label for="NomerSurat">Nomor Surat:</label>
    <input type="text" name="NomerSurat" value="<?= esc($NomerSurat); ?>">
    <br>
    <label for="TanggalSurat">Tanggal Surat:</label>
    <input type="date" name="TanggalSurat" value="<?= esc($TanggalSurat); ?>">
    <br>
    <label for="DataSurat">Data Surat:</label>
    <input type="text" name="DataSurat" value="<?= esc($DataSurat); ?>">
    <br>
    <label for="jenisFilter">Jenis Surat:</label>
    <select name="jenisFilter" id="jenisFilter">
        <!-- <option value="all">Semua Surat</option> -->
        <?php foreach ($jenisFilter as $value) : ?>
            <option value="<?= esc($value['id']); ?>" <?= ($value['id'] == $JenisSuratArchice_id) ? 'selected' : ''; ?>>
                <?= esc($value['name']); ?>
            </option>
        <?php endforeach; ?>
    </select>
    <p><span style="color: red;"><strong>Mohon maaf Untuk File Tidak Dapat Di update</strong></span></p>
    <br>
    <input type="submit" value="Update">
</form>


<br>
<?= TombolID('delete-archive-surat', $id, 'signature', 'Delete') ?>


<?= $this->endSection() ?>