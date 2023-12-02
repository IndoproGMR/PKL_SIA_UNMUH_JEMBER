<?= $this->extend('templates/layout.php') ?>

<?= $this->section('style') ?>
<link rel="stylesheet" href="<?= base_url('/css/tablestyle.css'); ?>">
<?= $this->endSection() ?>

<?= $this->section('main') ?>




<form class="inputform" action="/input-jenis-archive-surat" id="inputJenisSurat" style="display: none;">
    <input type="submit" value="Tambah Jenis Surat">
</form>
<br>
<br>
<form action="" method="post" class="inputform">
    <?= csrf_field() ?>

    <div>
        <label for="Name">Nama Jenis Surat:</label>
        <input type="text" name="Name" id="Name">
    </div>

    <div>
        <label for="DiskripsiJenis">Deskripsi Jenis Surat:</label>
        <input type="text" name="DiskripsiJenis" id="DiskripsiJenis">
    </div>
    <br>
    <input type="submit" value="Simpan">
</form>

<table>
    <thead>
        <tr>
            <th>no.</th>
            <th>nama</th>
            <th>deskripsi</th>
            <th>actions</th>
        </tr>
    </thead>
    <tbody>
        <?php $indexnum = 1; ?>

        <?php foreach ($jenisFilter as $index => $value) : ?>
            <?php if ($value['id'] > 0) : ?>
                <tr>
                    <td class="num"><?= esc($indexnum++) ?></td>
                    <td><?= esc($value['name']) ?></td>
                    <td><?= esc($value['description']) ?></td>
                    <td>

                        <?= view_cell('TombolIdCell', [
                            'link'              => 'staff/edit/JenisSurat',
                            'valueinput'        => $value['id'],
                            'tombolsubmitclass' => 'Actions',
                            'textsubmit'        => 'edit Jenis Surat',
                            'confirmdialog'     => false,
                        ]) ?>

                    </td>
                </tr>
            <?php endif ?>
        <?php endforeach ?>
    </tbody>
</table>



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
</script>
<?= $this->endSection() ?>