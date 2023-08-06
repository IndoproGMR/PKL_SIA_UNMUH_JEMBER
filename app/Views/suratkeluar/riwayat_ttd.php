<?= $this->extend('templates/layout.php') ?>
<?= $this->section('style') ?>
<link rel="stylesheet" href="<?= base_url('/'); ?>css/status.css">
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
                <th>Preview</th>
                <th>Tanggal di TandaTangani</th>
                <th>Nomer</th>
                <th>Status TTD</th>
            </tr>
        </thead>

        <tbody>
            <?php foreach ($datasurat as $key) : ?>
                <tr>
                    <td><?= esc($key['namaJenisSurat']) ?></td>
                    <td><?= TombolID('staff/Preview-Surat', $key['NoSurat'], 'signature', 'Preview Surat', '_blank') ?></td>
                    <td><?= esc(timeconverter($key['TimeStamp_ttd'])) ?></td>
                    <td><?= esc($key['NoSurat']) ?></td>
                    <td>
                        Sudah Di Tanda Tangani
                    </td>
                </tr>
            <?php endforeach ?>
        </tbody>
    </table>
</div>

<?= $this->endSection() ?>