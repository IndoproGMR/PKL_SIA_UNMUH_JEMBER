<?= $this->extend('templates/layout.php') ?>

<?= $this->section('style') ?>
<link rel="stylesheet" href="<?= base_url('/'); ?>css/status.css">
<?= $this->endSection() ?>

<?= $this->section('main') ?>

<div class="filter">
    <p class="first">Filter:
    <form action="">
        <select name="filter" id="filter">
            <option value="all">semua Surat</option>
            <?php foreach ($jenisFilter as $value) : ?>
                <option value="<?= esc($value['id']); ?>" <?= ($value['id'] == $filter) ? 'selected' : ''; ?>>
                    <?= esc($value['name']); ?>
                </option>
            <?php endforeach ?>
        </select>
        <button type="submit">Cari surat</button>
    </form>
    </p>
    <p class="third">Tanggal: <span><?= esc(timeconverter(time(), 'hijriahtgl')) ?></span></p>
</div>

<?php
dialog();


?>

<div class="table-rown">
    <table>

        <thead>
            <tr>
                <th>Jenis Surat</th>
                <th>Diskripsi Surat</th>
                <th>Nomer Surat</th>
                <th>Tanggal Surat</th>
                <th>Actions</th>
            </tr>
        </thead>

        <tbody>
            <?php foreach ($surat as $value) : ?>

                <tr>
                    <td>
                        <?= esc($value['JenisSurat']) ?>
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
                        <?= TombolID('staff/Surat-Archive', $value['idSurat'], 'signature', 'Liat Surat') ?>
                        <?= TombolID('detail-archive-surat', $value['idSurat'], 'signature', 'edit Surat') ?>
                    </td>
                </tr>
            <?php endforeach ?>

        </tbody>

    </table>
</div>


<?= $this->endSection() ?>