<?= $this->extend('templates/layout.php') ?>

<?= $this->section('style') ?>
<style>
    .kontenerinput {
        padding: 15px;
    }

    .kontensurat {
        text-align: center;
    }
</style>
<?= $this->endSection() ?>

<?= $this->section('main') ?>



<div class="filter">
    <p class="first">Filter:</p>
    <p class="second">Jenis Surat</p>
    <form>
        <?= view_cell('SelectOptionCell', [
            'options'      => $jenissurat,
            'nameselect'   => 'jenissuratid',
            'idselect'     => 'jenissuratid',
        ]) ?>
        <input type="button" value="Cari" onclick="mintaa()">
    </form>
    <?= timedecor() ?>
</div>


<?php if ($minta == 1) : ?>
    <form class="inputform" action="<?= base_url('/Surat-Input_Proses/Minta-TandaTangan'); ?>" enctype="multipart/form-data" method="post" accept-charset="utf-8">

        <?= csrf_field() ?>
        <input type="hidden" name="id" value="<?= esc($datasurat['id']) ?>">

        <table>
            <tr>
                <td>Nama Surat:</td>
                <td>
                    <strong><?= esc($datasurat['name']) ?></strong>
                </td>
            </tr>
            <tr>
                <td>Diskripsi Surat:</td>
                <td>
                    <strong><?= esc($datasurat['description']) ?></strong>
                </td>
            </tr>
            <tr>
                <td>Preview Surat:</td>
                <td>
                    <?= view_cell('TombolIdCell', [
                        'link'              => '/Preview_Master-Surat/' . $datasurat['id'],
                        'tombolsubmitclass' => 'Actions',
                        'textsubmit'        => 'Preview Surat',
                        'target'            => '_blank',
                        'method'            => 'redirect'
                    ]) ?>


                </td>
            </tr>
        </table>

        <br>
        <?php foreach ($dataform['input'] as $inputfild) : ?>
            <div>
                <label for="<?= esc($inputfild) ?>"><?= esc($inputfild) ?>:</label>
                <input type="text" name="<?= esc($inputfild) ?>" id="<?= esc($inputfild) ?>">
            </div>
        <?php endforeach ?>

        <?php if (isset($dataform['tambahan'])) : ?>
            <?php if (in_array('foto', $dataform['tambahan'])) : ?>
                <div>
                    <label for="foto">Foto:</label>
                    <input type="file" name="foto" id="foto" accept="image/*">
                </div>
            <?php endif ?>
        <?php endif ?>

        <br>
        <input type="submit" value="Minta Surat">
    </form>
<?php endif ?>


<?= $this->endSection() ?>

<?= $this->section('jsF') ?>
<script>
    var url = "<?= base_url('/Surat/Minta-TandaTangan/'); ?>";

    function mintaa() {
        var idjenis = document.getElementById('jenissuratid').value;
        console.log(idjenis);

        window.location.href = url + idjenis;
    }
</script>
<?= $this->endSection() ?>