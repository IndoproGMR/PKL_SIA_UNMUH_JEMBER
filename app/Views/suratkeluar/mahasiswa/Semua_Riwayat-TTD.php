<?= $this->extend('templates/layout.php') ?>
<?= $this->section('style') ?>
<link rel="stylesheet" href="<?= base_url('/css/tablestyle.css'); ?>">
<?= $this->endSection() ?>


<?php
$waktu = [
    [
        'id' => 1,
        'name' => '1 Bulan Lalu'
    ],
    [
        'id' => 2,
        'name' => '2 Bulan Lalu'
    ],
    [
        'id' => 3,
        'name' => '3 Bulan Lalu'
    ],
    [
        'id' => 6,
        'name' => '6 Bulan Lalu'
    ],
    [
        'id' => 9,
        'name' => '9 Bulan Lalu'
    ],
    [
        'id' => 12,
        'name' => '1 Tahun Lalu'
    ],
    [
        'id' => 18,
        'name' => '1 Tahun 6 Bulan Lalu'
    ],
    [
        'id' => 24,
        'name' => '2 Tahun Lalu'
    ]
];
?>

<?= $this->section('main') ?>

<div class="filter">
    <p class="first">Filter:</p>
    <form>
        <?= view_cell('SelectOptionCell', [
            'options'      => $waktu,
            'nameselect'   => 'filter_waktu',
            'idselect'     => 'filter_waktu',
            // 'firstoptions' => ['value' => 'all', 'name' => 'Semua Waktu'],
            'selected'     => $filter_waktu,
        ]) ?>
        <br>
        <?= view_cell('SelectOptionCell', [
            'options'      => $jenisFilter,
            'nameselect'   => 'filter',
            'idselect'     => 'filter',
            'firstoptions' => ['value' => 'all', 'name' => 'Semua Surat'],
            'selected'     => $filter,
        ]) ?>
        <br>
        <input type="submit" value="Cari">
    </form>
    <?= timedecor() ?>
</div>

<div class="table-rown">
    <table>
        <thead>
            <tr>
                <th>No.</th>
                <th>Jenis Surat</th>
                <th>Tanggal</th>
                <th>Nomer</th>
                <th>Actions</th>
            </tr>
        </thead>

        <tbody>
            <?php $indexnum = 1; ?>
            <?php foreach ($datasurat as $key) : ?>
                <tr>
                    <td class="num"><?= esc($indexnum++) ?></td>
                    <th><?= esc($key['namaJenisSurat']) ?></th>
                    <td><?= esc(timeconverter($key['TimeStamp'])) ?></td>
                    <td><?= esc($key['NoSurat']) ?></td>
                    <td>
                        <?= view_cell('TombolIdCell', [
                            'link'              => 'Download/Surat',
                            'valueinput'        => $key['NoSurat'],
                            'tombolsubmitclass' => 'Actions green',
                            'textsubmit'        => 'Download Surat'
                        ]) ?>
                    </td>
                </tr>
            <?php endforeach ?>
        </tbody>
    </table>
</div>

<?= $this->endSection() ?>