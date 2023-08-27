<?= $this->extend('templates/layout.php') ?>
<?= $this->section('style') ?>
<link rel="stylesheet" href="<?= base_url('/'); ?>css/tablestyle.css">
<?= $this->endSection() ?>

<?= $this->section('main') ?>

<div class="filter">
    <p class="first">Filter:</p>
    <form>
        <select>
            <option>PKL</option>
            <option>Surat Mahasiswa Aktif</option>
            <option>Surat Dispen</option>
        </select>
        <input type="submit" value="Cari">
    </form>
    <p class="Time">Tanggal: <span class="waktu-sekarang"></span></p>

</div>

<div class="table-rown">
    <table>
        <thead>
            <tr>
                <th>No.</th>
                <th>Jenis Surat</th>
                <th>Preview</th>
                <th>Tanggal</th>
                <th>Nomer</th>
                <th>Status TTD</th>
            </tr>
        </thead>

        <tbody>
            <?php foreach ($datasurat as $index => $key) : ?>
                <tr>
                    <td class="num"><?= esc($index + 1) ?></td>
                    <td><?= esc($key['namaJenisSurat']) ?></td>
                    <td><?= TombolID('staff/Preview-Surat', $key['NoSurat'], 'Actions', 'Preview Surat', '_blank') ?></td>
                    <td><?= esc(timeconverter($key['TimeStamp'])) ?></td>
                    <td><?= esc($key['NoSurat']) ?></td>
                    <td>(<?= esc($key['status']['sudah']) ?>/<?= esc($key['status']['totalTTD']) ?>)
                        <?= TombolID('status-TTD', $key['idttd'], 'Actions', 'TandaTangan') ?>
                    </td>
                </tr>
            <?php endforeach ?>
        </tbody>
    </table>
</div>

<?= $this->endSection() ?>