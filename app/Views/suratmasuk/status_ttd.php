<?= $this->extend('templates/layout.php') ?>
<?= $this->section('style') ?>
<link rel="stylesheet" href="css/status.css">
<?= $this->endSection() ?>

<?= $this->section('main') ?>

<div class="filter">
    <p class="first">Filter:</p>
    <p class="second">Jenis Surat</p>
    <form>
        <select>
            <option>PKL</option>
            <option>Surat Mahasiswa Aktif</option>
            <option>Surat Dispen</option>
        </select>
    </form>
    <p class="third">Tanggal</p>
</div>

<div class="table-rown">
    <table>
        <thead>
            <tr>
                <th>Jenis Surat</th>
                <th>Tanggal</th>
                <th>Nomer</th>
                <th>Status TTD</th>
            </tr>
        </thead>

        <tbody>
            <?php foreach ($datasurat as $key) : ?>
                <tr>
                    <th><?= esc($key['namaJenisSurat']) ?></th>
                    <td><?= esc(timeconverter($key['TimeStamp'])) ?></td>
                    <td><?= esc($key['NoSurat']) ?></td>
                    <td>(<?= esc($key['status']['sudah']) ?>/<?= esc($key['status']['totalTTD']) ?>)
                        <?= TombolID('/StatusTTD/proses', $key['idttd'], 'signature', 'TandaTangan') ?>
                    </td>
                </tr>
            <?php endforeach ?>
        </tbody>
    </table>
</div>

<?= $this->endSection() ?>