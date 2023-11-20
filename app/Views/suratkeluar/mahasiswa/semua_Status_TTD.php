<?= $this->extend('templates/layout.php') ?>
<?= $this->section('style') ?>
<link rel="stylesheet" href="<?= base_url('/css/tablestyle.css'); ?>">
<style>

</style>

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
                <th>Nomer</th>
                <th>Status TTD</th>
            </tr>
        </thead>

        <tbody>
            <?php $indexnum = 1; ?>
            <?php foreach ($datasurat as $key) : ?>
                <tr>
                    <td class="num"><?= esc($indexnum++) ?></td>
                    <td><?= esc($key['namaJenisSurat']) ?></td>
                    <td><?= esc(timeconverter($key['created_at'])) ?></td>

                    <?php if (esc($key['NoSurat']) == 'Belum_Memiliki_No_Surat') : ?>
                        <td style="color: red;"><?= esc($key['NoSurat']) ?> <span class="morInpo"><?= esc($key['SuratIdentifier']) ?></span></td>
                    <?php else : ?>
                        <td><?= esc($key['NoSurat']) ?> <span class="morInpo"><?= esc($key['SuratIdentifier']) ?></span></td>
                    <?php endif ?>

                    <!-- Buat info bila surat telah tolak -->
                    <?php if ($key['StatusSurat'] == '1') : ?>
                        <td style="color: red;">Surat Ter Report <span class="morInpo">Mohon Hubungi Staff</span></td>
                    <?php else : ?>
                        <td>(<?= esc($key['status']['sudah']) ?>/<?= esc($key['status']['totalTTD']) ?>)</td>
                    <?php endif ?>
                </tr>
            <?php endforeach ?>
        </tbody>
    </table>
</div>

<?= $this->endSection() ?>