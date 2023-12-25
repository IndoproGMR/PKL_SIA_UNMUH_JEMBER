<?= $this->extend('templates/layout.php') ?>
<?= $this->section('style') ?>
<link rel="stylesheet" href="<?= base_url('/css/tablestyle.css'); ?>">
<?= $this->endSection() ?>

<?= $this->section('main') ?>

<h2>SK_ttd_MintaSurat</h2>
<table>
    <thead>
        <th>No.</th>
        <th>mshw_id</th>
        <th>NoSurat</th>
        <th>SuratIdentifier</th>
        <th>Report_diskripsi</th>

        <th>created_at</th>
        <th>updated_at</th>
        <th>deleted_at</th>

        <th>Actions</th>
    </thead>
    <tbody>
        <?php $index = 1; ?>
        <?php foreach ($SK_ttd_MintaSurat as $indexa => $key) : ?>
            <tr>
                <td class="num"><?= esc($index++) ?></td>

                <td><?= esc($key['mshw_id']) ?></td>
                <td><?= esc($key['NoSurat']) ?></td>
                <td><?= esc($key['SuratIdentifier']) ?></td>
                <td><?= esc($key['Report_diskripsi']) ?></td>

                <td><?= esc($key['created_at']) ?></td>
                <td><?= esc($key['updated_at']) ?></td>
                <td><?= esc($key['deleted_at']) ?></td>

                <td><?= esc($key['Actions']) ?></td>
            </tr>
        <?php endforeach ?>

    </tbody>
</table>


<?= $this->endSection() ?>