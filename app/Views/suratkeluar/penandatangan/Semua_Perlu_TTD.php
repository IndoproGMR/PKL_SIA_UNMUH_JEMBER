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
                    <td><?= esc(timeconverter($key['TimeStamp'])) ?></td>
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
                            'link'              => 'staff/Preview-Surat',
                            'valueinput'        => $key['NoSurat'],
                            'tombolsubmitclass' => 'Actions',
                            'textsubmit'        => 'Preview Surat',
                            'target'            => '_blank',
                            'method'            => 'post'
                        ]) ?>

                        <?= view_cell('TombolIdCell', [
                            'link'              => '/',
                            'valueinput'        => $key['idttd'],
                            'tombolsubmitclass' => 'Actions danger-hover',
                            'textsubmit'        => 'Report Surat',
                            'method'            => 'get'
                        ]) ?>
                    </td>
                </tr>
            <?php endforeach ?>
        </tbody>
    </table>
</div>

<?= $this->endSection() ?>