<?= $this->extend('templates/layout.php') ?>

<?= $this->section('style') ?>
<style>
</style>
<?= $this->endSection() ?>

<?= $this->section('main') ?>


<br>
<br>
<form class="inputform" action="<?= esc(base_url('/staff/input-proses/archive-surat')) ?>" enctype="multipart/form-data" method="post" accept-charset="utf-8">
    <?= csrf_field() ?>
    <h1>Input Surat</h1>

    <div>
        <label for="jenissuratid" class="required">Jenis Surat:</label>
        <br>
        <?= view_cell(
            'SelectOptionCell',
            [
                'options'      => $jenisFilter,
                'nameselect'   => 'jenissuratid',
                'idselect'     => 'jenissuratid',
                'lastoptions'  => ['value' => '---', 'name' => 'Tidak Ketemu Jenis Surat ?'],
                'onchange'     => 'cek()',
            ]
        )
        ?>
    </div>

    <div>
        <label for="DiskirpsiSurat">Deskripsi Surat:</label>
        <br>
        <input type="text" name="DiskirpsiSurat" id="DiskirpsiSurat">
    </div>

    <div>
        <label for="DataSurat">Data Surat:</label>
        <br>
        <input type="text" name="DataSurat" id="DataSurat">
    </div>

    <div>
        <label for="NomerSurat" class="required">Nomor Surat:</label>
        <br>
        <input type="text" name="NomerSurat" id="NomerSurat">
    </div>

    <div>
        <label for="TanggalSurat" class="required">Tanggal Surat:</label>
        <br>
        <input type="date" name="TanggalSurat" id="TanggalSurat">
    </div>

    <div>
        <label for="filepdf" class="required">Surat Scan:</label>
        <br>
        <input type="file" name="filepdf" id="filepdf" accept="image/*, .pdf">
    </div>
    <br>
    <input type="submit" value="Simpan">
</form>
<br><br>

<form action="/input-jenis-archive-surat" id="inputJenisSurat" class="inputform" style="display: none;">
    <h1>Tambahkan Jenis Surat Baru</h1>
    <input type="submit" value="Tambah Jenis Surat">
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