<?= $this->extend('templates/layout.php') ?>
<?= $this->section('style') ?>
<link rel="stylesheet" href="<?= base_url('/css/tablestyle.css'); ?>">
<?= $this->endSection() ?>

<?= $this->section('main') ?>

<div class="filter">
    <p class="first">Filter:</p>
    <?= timedecor() ?>
</div>



<div class="table-rown">
    <table>
        <thead>
            <tr>
                <th>No.</th>
                <th>Jenis Surat</th>
                <th>Tanggal di TandaTangani</th>
                <th>Nomer</th>
                <th>Status TTD</th>
                <th>Actions</th>
            </tr>
        </thead>

        <tbody>
            <?php $indexnum = 1; ?>
            <?php foreach ($datasurat as $key) : ?>
                <tr>
                    <td class="num"><?= esc($indexnum++) ?></td>
                    <td><?= esc($key['namaJenisSurat']) ?></td>

                    <td><?= esc(timeconverter($key['TimeStamp_ttd'])) ?></td>
                    <td><?= esc($key['NoSurat']) ?></td>
                    <td>
                        Sudah Di Tanda Tangani
                    </td>

                    <td>
                        <?= view_cell('TombolIdCell', [
                            'link'              => 'staff/Preview-Surat',
                            'valueinput'        => $key['NoSurat'],
                            'tombolsubmitclass' => 'Actions',
                            'textsubmit'        => 'Preview Surat',
                            'target'            => '_blank',
                            'method'            => 'post'
                        ]) ?>
                    </td>
                </tr>
            <?php endforeach ?>
        </tbody>
    </table>
</div>

<?= $this->endSection() ?>