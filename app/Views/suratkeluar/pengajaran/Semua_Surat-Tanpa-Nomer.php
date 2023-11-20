<?= $this->extend('templates/layout.php') ?>
<?= $this->section('style') ?>
<link rel="stylesheet" href="<?= base_url('/css/tablestyle.css'); ?>">
<?= $this->endSection() ?>

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

        <input type="text" name="TextF" id="TextF" placeholder="NIM / identiti" value="<?= esc($dataGetTextF) ?>">

        <div>
            <input type="date" name="tglS" id="" value="<?= esc($dateStart) ?>">
            =>
            <input type="date" name="tglE" id="" value="<?= esc($dateEnd) ?>">
        </div>

        <input type="submit" value="Cari">
    </form>

    <?= timedecor() ?>
</div>



<table>
    <thead>
        <tr>
            <th>No.</th>
            <th>NoSurat</th>
            <th>Jenis Surat</th>
            <th>Waktu Minta</th>
            <th>Nama Mahasiswa</th>
            <th>Actions</th>
        </tr>
    </thead>

    <tbody>
        <?php $index = 1; ?>
        <?php foreach ($datasurat as $indexa => $key) : ?>
            <tr>
                <td class="num"><?= esc($index++) ?></td>
                <td><?= esc($key['NoSurat']) ?></td>
                <td><?= esc($key['name']) ?></td>
                <td><?= esc(timeconverter($key['created_at'])) ?></td>

                <td><?= esc($key['namaMahasiswa']['Nama']) . moreInfo($key['SuratIdentifier']) ?></td>

                <td>
                    <?= view_cell('TombolIdCell', [
                        'link'              => '/Staff/Edit/Permintaan_TTD-Surat_Tanpa_NoSurat',
                        'valueinput'        => $key['id'],
                        'tombolsubmitclass' => 'Actions',
                        'textsubmit'        => 'Edit Surat',
                        'confirmdialog'     => true,
                        'textConfirm'       => 'edit Surat ini ?',
                        'target'            => '_self'
                    ]) ?>

                    <?= view_cell('TombolIdCell', [
                        'link'              => '/Preview_Surat-Mahasiswa/' . $key['SuratIdentifier'],
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


<?= $this->endSection() ?>