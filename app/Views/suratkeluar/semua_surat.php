<?= $this->extend('templates/layout.php') ?>

<?= $this->section('style') ?>
<link rel="stylesheet" href="<?= base_url('/'); ?>css/status.css">
<?= $this->endSection() ?>

<?= $this->section('main') ?>

<div class="filter">
    <p class="first">Filter:</p>
    <p class="third">Tanggal: <span><?= esc(timeconverter(time(), 'hijriahtgl')) ?></span></p>
</div>

<div class="table-rown">
    <table>

        <thead>
            <tr>
                <th>Jenis Surat</th>
                <th>Preview</th>
                <th>Diskripsi Surat</th>
                <th>Show Status</th>
                <th>Edit Surat</th>
            </tr>
        </thead>

        <tbody>
            <?php foreach ($jenissurat as $key) : ?>
                <tr>
                    <td><?= esc($key['name']) ?></td>
                    <td><?= TombolTo('/Preview/' . $key['id'], 'Preview Surat', 'signature', '_blank') ?></td>
                    <td><?= esc($key['description']) ?></td>
                    <?php if ($key['show'] == 0) : ?>
                        <td><?= TombolIDcheck(0, '/toggleshow-surat', $key['id']) ?></td>
                    <?php elseif ($key['show'] == 1) : ?>
                        <td><?= TombolIDcheck(1, '/toggleshow-surat', $key['id']) ?></td>
                    <?php endif ?>
                    <td><?= TombolTo('/detail-surat/' . $key['id'], 'edit Surat', 'signature') ?></td>
                </tr>
            <?php endforeach ?>
        </tbody>

    </table>
</div>


<?= $this->endSection() ?>