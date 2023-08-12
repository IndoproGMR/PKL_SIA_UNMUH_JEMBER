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
<?= form_open_multipart('') ?>
<?= csrf_field() ?>
<div>
    <label for="jenissuratid">Jenis Surat:</label>
    <select name="jenissuratid" id="jenissuratid" onchange="cek()">
        <?php foreach ($jenisFilter as $value) : ?>
            <option value="<?= esc($value['id']) ?>"><?= esc($value['name']) ?></option>
        <?php endforeach ?>
        <option value="---">Tidak Ketemu Jenis Surat ?</option>
    </select>
</div>
<div>
    <label for="DiskirpsiSurat">Deskripsi Surat:</label>
    <input type="text" name="DiskirpsiSurat" id="DiskirpsiSurat">
</div>
<div>
    <label for="NomerSurat">Nomor Surat:</label>
    <input type="text" name="NomerSurat" id="NomerSurat">
</div>
<div>
    <label for="TanggalSurat">Tanggal Surat:</label>
    <input type="date" name="TanggalSurat" id="TanggalSurat">
</div>
<div>
    <label for="DataSurat">Data Surat:</label>
    <input type="text" name="DataSurat" id="DataSurat">
</div>

<div>
    <label for="filepdf">Surat Scan:</label>
    <input type="file" name="filepdf" id="filepdf">
</div>

<input type="submit" value="Simpan">
</form>

<br><br>
<ol>
    <li>
        Max uploadnya berapa besar?
    </li>
    <li>
        Apa saja yang harus diisi?
    </li>
    <li>
        File-nya apa saja? (PDF saja atau gambar juga?)
    </li>
</ol>

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
    cek();
</script>
<?= $this->endSection() ?>