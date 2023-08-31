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
    <div class="kontensurat">
        <h1><?= esc($datasurat['name']) ?></h1>
        <h3><?= esc($datasurat['description']) ?></h3>
        <h3><?= TombolTo('/Preview/' . $datasurat['id'], 'Preview Surat', '', '_blank') ?></h3>
    </div>


    <?= form_open_multipart('') ?>
    <?php
    inputform($dataform['input']);
    if (isset($dataform['tambahan'])) {
        if (in_array('foto', $dataform['tambahan'])) {
            echo '<input type="file" name="foto">';
        }
    }
    ?>

    <br>
    <input type="submit" value="sumit">
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