<?= $this->extend('templates/layout.php') ?>

<?= $this->section('style') ?>
<link rel="stylesheet" href="<?= base_url('/'); ?>css/tablestyle.css">
<?= $this->endSection() ?>




<?= $this->section('main') ?>

<div class="filter">
    <p class="first">Filter:</p>
    <form>
        <?= view_cell('SelectOptionCell', [
            'options'      => $jenisFilter,
            'nameselect'   => 'filter',
            'idselect'     => 'filter',
            'firstoptions' => ['value' => 'all', 'name' => 'Semua Surat'],
            'selected'     => $filter,
        ]) ?>
        <br>

        <div>
            <input type="date" name="tglS" id="tglS" value="<?= esc($dateStart) ?>">
            =>
            <input type="date" name="tglE" id="tglE" value="<?= esc($dateEnd) ?>">
        </div>

        <input type="number" name="limit" id="limit" value="<?= esc($Datalimit) ?>">

        <input type="button" value="Clear" id="clear">
        <!-- <button>Clear Query</button> -->
        <br>
        <input type="text" name="TextF" id="TextF" placeholder="Diskripsi / Nomer Surat" value="<?= esc($dataGetTextF) ?>">
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
                <th>Diskripsi Surat</th>
                <th>Nomer Surat</th>
                <th>Tanggal Surat</th>
                <th>Actions</th>
            </tr>
        </thead>

        <tbody>
            <?php foreach ($surat as $index => $value) : ?>

                <tr>
                    <td class="num"><?= esc($index + 1) ?></td>
                    <td>
                        <?php if ($value['JenisSurat'] == 'tidak diketahui') : ?>
                            <span style="background-color: red;padding: 5px; color: white;"><?= esc($value['JenisSurat']) ?></span>
                        <?php else : ?>
                            <?= esc($value['JenisSurat']) ?>
                        <?php endif ?>
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

                        <?= view_cell('TombolIdCell', [
                            'link'              => 'staff/Surat-Archive',
                            'valueinput'        => $value['idSurat'],
                            'tombolsubmitclass' => 'Actions',
                            'textsubmit'        => 'Liat Surat',
                            'target'            => '_blank'
                        ]) ?>

                        <?= view_cell('TombolIdCell', [
                            'link'              => 'detail_edit/archive-surat',
                            'valueinput'        => $value['idSurat'],
                            'tombolsubmitclass' => 'Actions',
                            'textsubmit'        => 'Edit Surat',
                            'target'            => '_self'
                        ]) ?>

                    </td>
                </tr>
            <?php endforeach ?>

        </tbody>

    </table>
</div>


<?php if (count($suratNoJenis) > 0) : ?>
    <br>
    <br>
    <br>

    <section id="TanpaJenisSurat">
        <div class="table-rown">
            <table>
                <thead>
                    <tr>
                        <th>No.</th>
                        <th>Jenis Surat</th>
                        <th>Diskripsi Surat</th>
                        <th>Nomer Surat</th>
                        <th>Tanggal Surat</th>
                        <th>Actions</th>
                    </tr>
                </thead>

                <tbody>
                    <?php foreach ($suratNoJenis as $index => $value) : ?>

                        <tr>
                            <td class="num"><?= esc($index + 1) ?></td>
                            <td>
                                <span style="background-color: red;padding: 5px; color: white;border-radius: 5px;">Tidak Diketahui</span>
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

                                <?= view_cell('TombolIdCell', [
                                    'link'              => 'staff/Surat-Archive',
                                    'valueinput'        => $value['idSurat'],
                                    'tombolsubmitclass' => 'Actions',
                                    'textsubmit'        => 'Liat Surat',
                                    'target'            => '_blank'
                                ]) ?>

                                <?= view_cell('TombolIdCell', [
                                    'link'              => 'detail_edit/archive-surat',
                                    'valueinput'        => $value['idSurat'],
                                    'tombolsubmitclass' => 'Actions',
                                    'textsubmit'        => 'Edit Surat',
                                    'target'            => '_self'
                                ]) ?>

                            </td>
                        </tr>
                    <?php endforeach ?>

                </tbody>

            </table>
        </div>
    </section>

<?php endif ?>


<?= $this->endSection() ?>

<?= $this->section('jsF') ?>
<script>
    const clearButton = document.getElementById('clear');

    const TextF = document.getElementById('TextF');
    const filter = document.getElementById('filter');
    const limit = document.getElementById('limit');

    const tglS = document.getElementById('tglS');
    const tglE = document.getElementById('tglE');

    clearButton.addEventListener('click', () => {
        tglS.value = null;
        tglE.value = null;
        filter.value = 'all';
        TextF.value = null;
        limit.value = 10;
    });
</script>
<?= $this->endSection() ?>