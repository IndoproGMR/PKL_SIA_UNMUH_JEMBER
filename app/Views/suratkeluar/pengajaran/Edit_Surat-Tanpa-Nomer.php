<?= $this->extend('templates/layout.php') ?>

<?= $this->section('style') ?>
<style>
    .Status-con {
        padding: 10px;
    }

    .status {
        padding: 3px;
        border-radius: 5px;
    }
</style>
<?= $this->endSection() ?>

<?= $this->section('main') ?>




<form class="inputform" action="<?= base_url('/Staff/Edit-proses/Permintaan_TTD-Surat_Tanpa_NoSurat'); ?>" method="post">
    <?= csrf_field() ?>
    <input type="hidden" name="id" value="<?= esc($id); ?>">

    <table>
        <tbody>
            <tr>
                <td>mahasiswa yang buat:</td>
                <td><?= esc($namaMHS); ?></td>
            </tr>
            <tr>
                <td>kapan Surat Dibuat:</td>
                <td><?= esc(timeconverter($created_at)) ?></td>
            </tr>
            <tr>
                <td>Jenis Surat:</td>
                <td><?= esc($name); ?></td>
            </tr>
            <tr>
                <td>Surat Identifier:</td>
                <td><?= esc($SuratIdentifier) ?></td>
            </tr>
        </tbody>
    </table>

    <br>
    <div>
        <label for="NoSurat">NoSurat Surat:</label>
        <br>
        <input type="text" name="NoSurat" id="NoSurat">
    </div>
    <input type="submit" value="Update" id="tombolUpdate" class="Actions danger" disabled>
</form>
<br>
<hr>
<br>

<div class="outForm">
    <button id="cekNomer" class="Actions ">cek nomer</button>
    <br>
    <p class="Status-con">Status: <span id="Status">unknown</span></p>
    <br>
    <label for="ceklist" class="required">Mohon Confirm: </label>
    <input type="hidden" name="" id="ceklist">
</div>
<br>
<hr>
<br>

<div class="outForm">
    <?= view_cell('TombolIdCell', [
        'link'              => '/Preview_Surat-Mahasiswa/' . $SuratIdentifier,
        'valueinput'        => $id,
        'tombolsubmitclass' => 'Actions',
        'textsubmit'        => 'Preview Surat',
        'confirmdialog'     => false,
        'target'            => '_blank',
        'method'            => 'redirect'
    ]) ?>


    <?= view_cell('TombolIdCell', [
        'link'              => 'delete-proses/surat-tanpa_NoSurat',
        'valueinput'        => $id,
        'tombolsubmitclass' => 'Actions danger',
        'textsubmit'        => 'Delete Surat',
        'confirmdialog'     => true,
        'target'            => '_self',
        'method'            => 'post'
    ]) ?>

    <?= view_cell('TombolIdCell', [
        'link'              => 'BlackList-Mahasiswa',
        'valueinput'        => $mshw_id,
        'tombolsubmitclass' => 'Actions danger',
        'textsubmit'        => 'BlackList Peminta',
        'confirmdialog'     => true,
        'target'            => '_self',
        'method'            => 'post'
    ]) ?>

</div>


<?= $this->endSection() ?>

<?= $this->section('jsF') ?>
<script>
    const url_api = "<?= base_url(getenv('urlapi') . '/cekNomerSurat')  ?>";

    // Input field
    document.getElementById('NoSurat').addEventListener("input", () => {
        document.getElementById("tombolUpdate").classList.add('danger');
        document.getElementById("tombolUpdate").setAttribute('disabled', '');
        document.getElementById("ceklist").type = 'hidden';
        document.getElementById("ceklist").checked = false;
    });

    document.getElementById('ceklist').addEventListener("click", () => {
        document.getElementById("tombolUpdate").classList.remove('danger')
        document.getElementById("tombolUpdate").removeAttribute('disabled');
    });



    document.getElementById("cekNomer").addEventListener("click", () => {
        var nomerSurat = btoa(document.getElementById("NoSurat").value);
        var statusSpan = document.getElementById("Status");
        var ceklist = document.getElementById("ceklist");

        if (nomerSurat == '') {
            statusSpan.className = 'danger';
            return;
        }

        statusSpan.textContent = 'LOADING...'
        statusSpan.className = 'danger';
        ceklist.type = 'hidden';


        var url = url_api + '?NoSurat=' + nomerSurat;
        // Panggil API dengan nomer surat
        fetch(url, {
                method: "get",
                headers: {
                    "X-token": getCookie('API')
                }
            })
            .then(function(response) {
                if (response.status != 200) {
                    const data = {
                        'massage_status': 1,
                        'massage': response.statusText
                    };
                    return data;
                }
                return response.json(); // Mengambil data JSON dari respons
            })
            .then(function(data) {
                // Mengubah status berdasarkan respons API
                statusSpan.textContent = data.massage;
                if (data.massage_status == 1) {
                    // Menambahkan class 'danger' dan menghapus class 'good'
                    statusSpan.className = 'danger';
                    document.getElementById("tombolUpdate").classList.add('danger')
                    document.getElementById("tombolUpdate").setAttribute('disabled', '');
                    document.getElementById("ceklist").checked = false;


                } else if (data.massage_status == 0) {
                    // Menambahkan class 'good' dan menghapus class 'danger'
                    statusSpan.className = 'green';
                    ceklist.type = 'checkbox';
                } else {
                    // Jika status tidak sama dengan 1 atau 0, hapus kelas yang ada
                    statusSpan.className = '';
                    document.getElementById("tombolUpdate").classList.add('danger')
                    document.getElementById("tombolUpdate").setAttribute('disabled', '');
                    document.getElementById("ceklist").checked = false;
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