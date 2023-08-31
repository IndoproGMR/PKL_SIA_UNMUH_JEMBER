<?= $this->extend('templates/layout.php') ?>
<?= $this->section('style') ?>
<link rel="stylesheet" href="<?= base_url('/'); ?>css/tablestyle.css">

<?= $this->endSection() ?>

<?= $this->section('main') ?>

<div class="filter">
    <p class="first">Filter:</p>
    <form>
        <select name="" id="">
            <option value="">a</option>
            <option value="">b</option>
            <option value="">aaaaaaaaaaaaaaaa bbbbbbbb ccccccccccccc</option>
        </select>
        <input type="submit" value="Cari">
    </form>
    <?= timedecor() ?>
</div>



<table>
    <thead>
        <tr>
            <th>no</th>
            <th>NoSurat</th>
            <th>jenis Surat</th>
            <th>TimeStamp</th>
            <th>nama mahasiswa</th>
            <th>Actions</th>
        </tr>
    </thead>

    <tbody>
        <?php foreach ($datasurat as $index => $key) : ?>
            <tr>
                <td class="num"><?= esc($index + 1) ?></td>
                <td><?= esc($key['NoSurat']) ?></td>
                <td><?= esc($key['name']) ?></td>
                <td><?= esc(timeconverter($key['TimeStamp'])) ?></td>
                <td><?= esc($key['namaMahasiswa']['Nama']) ?></td>
                <td>
                    <?= view_cell('TombolIdCell', [
                        'link'              => '/Staff/Edit/Permintaan_TTD-Surat_Tanpa_NoSurat',
                        'valueinput'        => $key['id'],
                        'tombolsubmitclass' => 'Actions',
                        'textsubmit'        => 'Edit Surat',
                        'confirmdialog'     => true,
                        'textConfirm'       => 'edit Surat ini ?',
                        'target'            => '_self'
                    ]) ?>

                    <?= view_cell('TombolIdCell', [
                        'link'              => 'staff/Preview-Surat',
                        'valueinput'        => $key['id'],
                        'tombolsubmitclass' => 'Actions',
                        'textsubmit'        => 'Preview Surat',
                        'confirmdialog'     => false,
                        'target'            => '_blank'
                    ]) ?>
                </td>
            </tr>
        <?php endforeach ?>
    </tbody>
</table>


<?= $this->endSection() ?>