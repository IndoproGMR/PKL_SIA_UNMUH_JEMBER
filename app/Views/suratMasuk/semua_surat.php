<?= $this->extend('templates/layout.php') ?>

<?= $this->section('style') ?>
<link rel="stylesheet" href="<?= base_url('/'); ?>css/tablestyle.css">
<?= $this->endSection() ?>

<?= $this->section('main') ?>


<!-- <?= view_cell('DisplayErrorCell', ['dataterima' => '["data dikirim","data nomer2"]']) ?> -->



<div class="filter">
    <p class="first">Filter:
    <form action="">
        <?= view_cell('SelectOptionCell', [
            'options'      => $jenisFilter,
            'nameselect'   => 'filter',
            'idselect'     => 'filter',
            'firstoptions' => ['value' => 'all', 'name' => 'Semua Surat'],
            'selected'     => $filter,
        ]) ?>
        <input type="submit" value="Cari surat">
    </form>
    </p>
    <p class="Time">Tanggal: <span class="waktu-sekarang"></span></p>

</div>






<div class="table-rown">
    <table>

        <thead>
            <tr>
                <th>No.</th>
                <th>Jenis Surat</th>
                <th>Diskripsi Surat</th>
                <th>Nomer Surat</th>
                <th>Tanggal Surat</th>
                <th>Actions</th>
            </tr>
        </thead>

        <tbody>
            <?php foreach ($surat as $index => $value) : ?>

                <tr>
                    <td class="num"><?= esc($index + 1) ?></td>
                    <td>
                        <?php if ($value['JenisSurat'] == 'tidak diketahui') : ?>
                            <span style="background-color: red;padding: 5px; color: white;"><?= esc($value['JenisSurat']) ?></span>
                        <?php else : ?>
                            <?= esc($value['JenisSurat']) ?>
                        <?php endif ?>
                    </td>

                    <td>
                        <?= esc($value['DiskripsiSurat']) ?>
                    </td>

                    <td>
                        <?= esc($value['NoSurat']) ?>
                    </td>

                    <td>
                        <?= esc($value['TanggalSurat']) ?>
                    </td>

                    <td>

                        <?= view_cell('TombolIdCell', [
                            'link'              => 'staff/Surat-Archive',
                            'valueinput'        => $value['idSurat'],
                            'tombolsubmitclass' => 'Actions',
                            'textsubmit'        => 'Liat Surat',
                            'target'            => '_blank'
                        ]) ?>

                        <?= view_cell('TombolIdCell', [
                            'link'              => 'detail_edit/archive-surat',
                            'valueinput'        => $value['idSurat'],
                            'tombolsubmitclass' => 'Actions',
                            'textsubmit'        => 'Edit Surat',
                            'target'            => '_self'
                        ]) ?>

                    </td>
                </tr>
            <?php endforeach ?>

        </tbody>

    </table>
</div>


<?= $this->endSection() ?>