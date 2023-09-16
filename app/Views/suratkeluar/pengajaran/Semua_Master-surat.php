<?= $this->extend('templates/layout.php') ?>

<?= $this->section('style') ?>
<link rel="stylesheet" href="<?= base_url('/css/tablestyle.css'); ?>">

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
                <th>Diskripsi Surat</th>
                <th>Show Status</th>
                <th>Action</th>
            </tr>
        </thead>

        <tbody>
            <?php $indexnum = 1; ?>
            <?php foreach ($jenissurat as $key) : ?>
                <tr>
                    <td class="num"><?= esc($indexnum++) ?></td>
                    <td><?= esc($key['name']) ?></td>
                    <td><?= esc($key['description']) ?></td>

                    <?php if ($key['show'] == 0) : ?>
                        <td><?= TombolIDcheck(0, '/toggleshow-surat', $key['id']) ?></td>
                    <?php elseif ($key['show'] == 1) : ?>
                        <td><?= TombolIDcheck(1, '/toggleshow-surat', $key['id']) ?></td>
                    <?php endif ?>

                    <td>

                        <?= view_cell('TombolIdCell', [
                            'link'              => '/Staff/detail/Master-Surat/' . $key['id'],
                            'valueinput'        => $key['id'],
                            'tombolsubmitclass' => 'Actions',
                            'textsubmit'        => 'Edit Surat',
                            'confirmdialog'     => true,
                            'method'            => 'get'
                        ]) ?>

                        <?= view_cell('TombolIdCell', [
                            'link'              => '/staff/Preview/' . $key['id'],
                            'valueinput'        => $key['id'],
                            'tombolsubmitclass' => 'Actions',
                            'textsubmit'        => 'Preview Surat',
                            'target'            => '_blank',
                            'confirmdialog'     => false,
                            'method'            => 'get'
                        ]) ?>

                        <?= view_cell('TombolIdCell', [
                            'link'              => '/Staff/test/Master-Surat/' . $key['id'],
                            'valueinput'        => $key['id'],
                            'tombolsubmitclass' => 'Actions',
                            'textsubmit'        => 'Test Surat',
                            'target'            => '_blank',
                            'confirmdialog'     => false,
                            'method'            => 'get'
                        ]) ?>

                    </td>
                </tr>
            <?php endforeach ?>
        </tbody>
    </table>
</div>


<?= $this->endSection() ?>