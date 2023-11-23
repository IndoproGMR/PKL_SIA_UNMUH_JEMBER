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
            'options'      => $jenisFilter,
            'nameselect'   => 'filter',
            'idselect'     => 'filter',
            'firstoptions' => ['value' => 'all', 'name' => 'Semua Surat'],
            'selected'     => $filter,
        ]) ?>
        <br>
        <input type="text" name="TextF" id="TextF" placeholder="NIM / Nomer Surat" value="<?= esc($dataGetTextF) ?>">


        <div id="filterChackbox" style="display: block;">
            <label for="filterquation">advanced mode ?</label>
            <input type="checkbox" id="filterquation">
        </div>

        <div id="fiterKontener" style="display: none;">
            <label for="tanggal">Filter dari tanggal hingga tanggal:</label>
            <div id="tanggal">
                <input type="date" name="tglS" id="" value="<?= esc($dateStart) ?>">
                =>
                <input type="date" name="tglE" id="" value="<?= esc($dateEnd) ?>">
            </div>
            <label for="limit">Limit Output:</label>
            <br>
            <input type="number" name="limit" id="limit" value="<?= esc($limit) ?>">
        </div>

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
                            'link'              => '/Preview_Surat-TandaTangan/' . $key['SuratIdentifier'],
                            'tombolsubmitclass' => 'Actions',
                            'textsubmit'        => 'Preview Surat',
                            'confirmdialog'     => false,
                            'target'            => '_blank',
                            'method'            => 'redirect'
                        ]) ?>
                    </td>
                </tr>
            <?php endforeach ?>
        </tbody>
    </table>
</div>

<?= $this->endSection() ?>