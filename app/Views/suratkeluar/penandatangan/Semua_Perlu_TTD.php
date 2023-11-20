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
                <th>Tanggal</th>
                <th>Nomer Surat</th>
                <th>TandaTangani Surat</th>
                <th>Actions</th>
            </tr>
        </thead>

        <tbody>
            <?php $indexnum = 1; ?>
            <?php foreach ($datasurat as $index => $key) : ?>
                <tr>
                    <td class="num"><?= esc($indexnum++) ?></td>
                    <td><?= esc($key['namaJenisSurat']) ?></td>
                    <td><?= esc(timeconverter($key['created_at'])) ?></td>
                    <td><?= esc($key['NoSurat']) ?></td>

                    <td>
                        <?= view_cell('TombolIdCell', [
                            'link'              => 'TandaTangan-proses/Surat_Perlu_TandaTangan',
                            'valueinput'        => $key['idttd'],
                            'tombolsubmitclass' => 'Actions',
                            'textsubmit'        => 'Tanda Tangani Surat',
                            'target'            => '_self',
                            'method'            => 'post'
                        ]) ?>
                    </td>
                    <td>
                        <?= view_cell('TombolIdCell', [
                            'link'              => '/Preview_Surat-Mahasiswa/' . $key['SuratIdentifier'],
                            'tombolsubmitclass' => 'Actions',
                            'textsubmit'        => 'Preview Surat',
                            'confirmdialog'     => false,
                            'target'            => '_blank',
                            'method'            => 'redirect'
                        ]) ?>

                        <?= view_cell('TombolIdCell', [
                            'link'              => '/Report-Surat',
                            'valueinput'        => $key['SuratIdentifier'],
                            'tombolsubmitclass' => 'Actions danger-hover',
                            'textsubmit'        => 'Report Surat',
                            'method'            => 'post'
                        ]) ?>
                    </td>
                </tr>
            <?php endforeach ?>
        </tbody>
    </table>
</div>

<?= $this->endSection() ?>