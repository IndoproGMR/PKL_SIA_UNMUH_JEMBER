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
            <tr>
                <th>PKL</th>
                <td>2-06-2023</td>
                <td>23457689</td>
                <td>(0/1)<a href="status-surat.html" class="signature">TANDA TANGAN</a></td>
            </tr>

            <tr>
                <th>PKL</th>
                <td>2-06-2023</td>
                <td>23457689</td>
                <td>(0/1)<a href="" class="signature">TANDA TANGAN</a></td>
            </tr>

            <tr>
                <th>PKL</th>
                <td>2-06-2023</td>
                <td>23457689</td>
                <td>(0/1)<a href="" class="signature">TANDA TANGAN</a></td>
            </tr>

        </tbody>
    </table>
</div>

<?= $this->endSection() ?>