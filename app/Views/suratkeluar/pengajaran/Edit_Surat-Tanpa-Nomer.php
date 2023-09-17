<?= $this->extend('templates/layout.php') ?>

<?= $this->section('style') ?>

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
    <input type="text" name="NoSurat" id="NoSurat">
    <br>
    <input type="submit" value="Update">
</form>


<button id="cekNomer">
    cek nomer
</button>
<p>Status: <span id="Status">unknown</span></p>

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

<?= $this->section('jsF') ?>
<script>
    const url_api = "<?= base_url(getenv('urlapi') . '/cekNomerSurat')  ?>";

    document.getElementById("cekNomer").addEventListener("click", function() {
        var nomerSurat = btoa(document.getElementById("NoSurat").value);
        var statusSpan = document.getElementById("Status");

        if (nomerSurat == '') {
            statusSpan.className = 'danger';
            return;
        }



        var url = url_api + '?nosurat=' + nomerSurat + "&token=" + getCookie('API');
        // console.log(url);
        // Panggil API dengan nomer surat
        fetch(url)
            .then(function(response) {
                return response.json(); // Mengambil data JSON dari respons
            })
            .then(function(data) {
                // Mengubah status berdasarkan respons API
                statusSpan.textContent = data.massage;

                if (data.status == 1) {
                    // Menambahkan class 'danger' dan menghapus class 'good'
                    statusSpan.className = 'danger';
                } else if (data.status == 0) {
                    // Menambahkan class 'good' dan menghapus class 'danger'
                    statusSpan.className = 'green';
                } else {
                    // Jika status tidak sama dengan 1 atau 0, hapus kelas yang ada
                    statusSpan.className = '';
                }
            })
            .catch(function(error) {
                statusSpan.className = 'danger';
                statusSpan.textContent = 'API error';
                console.error("Terjadi kesalahan:", error);
            });
    });

    function getCookie(name) {
        var cookieValue = null;
        if (document.cookie && document.cookie !== '') {
            var cookies = document.cookie.split(';');
            for (var i = 0; i < cookies.length; i++) {
                var cookie = cookies[i].trim();
                if (cookie.substring(0, name.length + 1) === (name + '=')) {
                    cookieValue = decodeURIComponent(cookie.substring(name.length + 1));
                    break;
                }
            }
        }
        return cookieValue;
    }
</script>
<?= $this->endSection() ?>