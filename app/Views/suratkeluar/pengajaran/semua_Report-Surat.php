<?= $this->extend('templates/layout.php') ?>
<?= $this->section('style') ?>
<link rel="stylesheet" href="<?= base_url('/css/tablestyle.css'); ?>">

<?= $this->endSection() ?>

<?= $this->section('main') ?>


<div class="filter">
    <p class="first">Filter:</p>
    <form>

        <input type="text" name="TextF" id="TextF" placeholder="NIM / Nomer Surat" value="<?= esc($dataGetTextF) ?>">


        <div id="filterChackbox" style="display: block;">
            <label for="filterquation">advanced mode ?</label>
            <input type="checkbox" id="filterquation">
        </div>

        <div id="fiterKontener" style="display: none;">

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
                <th>NoSurat</th>
                <th>Mahasiswa</th>
                <th>Pereport</th>
                <th>Diskripsi Report</th>
                <th>Tanggal report</th>
                <th>Actions</th>
            </tr>
        </thead>


        <!-- Perbaiki table -->
        <tbody>
            <?php $indexnum = 1; ?>
            <?php foreach ($Report as $key) : ?>
                <tr>
                    <td class="num"><?= esc($indexnum++) ?></td>
                    <td><?= esc($key['JenisSurat']) ?></td>
                    <td><?= esc($key['NoSurat']) ?></td>
                    <td><?= esc($key['mahasiswa']) ?></td>
                    <td><?= esc(pecahkan($key['Report_diskripsi']['Pereport'])[1]) ?></td>
                    <td><?= esc($key['Report_diskripsi']['isi']) ?></td>

                    <td><?= esc(timeconverter($key['updated_at'])) ?></td>


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
                            'link'              => '/Preview_Surat-Mahasiswa/' . $key['SuratIdentifier'],
                            'tombolsubmitclass' => 'Actions',
                            'textsubmit'        => 'Extra',
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