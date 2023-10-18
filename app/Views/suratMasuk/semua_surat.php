<?= $this->extend('templates/layout.php') ?>

<?= $this->section('style') ?>
<link rel="stylesheet" href="<?= base_url('/'); ?>css/tablestyle.css">
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
        <input type="date" name="TanggalSurat" id="TanggalSurat" value="<?= esc($TanggalSurat) ?>">
        <input type="button" value="Clear" id="clear">
        <!-- <button>Clear Query</button> -->
        <br>
        <input type="text" name="TextF" id="TextF" placeholder="Diskripsi / Nomer Surat" value="<?= esc($dataGetTextF) ?>">
        <input type="submit" value="Cari">
    </form>
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

<?= $this->section('jsF') ?>
<script>
    const clearButton = document.getElementById('clear');

    const TanggalSurat = document.getElementById('TanggalSurat');
    const TextF = document.getElementById('TextF');
    const filter = document.getElementById('filter');

    clearButton.addEventListener('click', () => {
        // console.log('klick');

        TanggalSurat.value = '';
        TextF.value = '';
        filter.value = 'all';

    });
</script>
<?= $this->endSection() ?>