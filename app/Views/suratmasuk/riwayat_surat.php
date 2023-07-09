<?= $this->extend('templates/layout.php') ?>
<?= $this->section('style') ?>
<link rel="stylesheet" href="css/status.css">
<?= $this->endSection() ?>

<?= $this->section('main') ?>

<div class="filter">
    <p class="first">Filter:</p>
    <p class="third">Tanggal: <span><?= esc(timeconverter(time())) ?></span></p>
</div>

<div class="table-rown">
    <table>
        <thead>
            <tr>
                <th>Jenis Surat</th>
                <th>Tanggal</th>
                <th>Nomer</th>
                <th>Status Surat</th>
            </tr>
        </thead>

        <tbody>
            <?php foreach ($datasurat as $key) : ?>
                <tr>
                    <th><?= esc($key['namaJenisSurat']) ?></th>
                    <td><?= esc(timeconverter($key['TimeStamp'])) ?></td>
                    <td><?= esc($key['NoSurat']) ?></td>
                    <td><?= TombolID('Download/Surat', $key['NoSurat'], 'signature', 'Download') ?></td>
                </tr>
            <?php endforeach ?>
        </tbody>
    </table>
</div>

<?= $this->endSection() ?>