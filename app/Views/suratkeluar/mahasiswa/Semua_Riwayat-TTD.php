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
                    <td><?= esc(timeconverter($key['created_at'])) ?></td>
                    <td><?= esc($key['NoSurat']) ?></td>
                    <td>
                        <?= view_cell('TombolIdCell', [
                            'link'              => 'Download_Surat',
                            'valueinput'        => $key['SuratIdentifier'],
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