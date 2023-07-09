<?= $this->extend('templates/layout.php') ?>

<?= $this->section('style') ?>
<link rel="stylesheet" href="<?= base_url('/'); ?>css/status.css">
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
        <select name="jenissuratid" id="jenissuratid">
            <?php foreach ($jenissurat as $datajenis) : ?>
                <option value="<?= esc($datajenis['id']) ?>"><?= esc($datajenis['name']) ?></option>
            <?php endforeach ?>
        </select>
        <button type="button" onclick="mintaa()">minta surat</button>
    </form>
    <p class="third">Tanggal: <span><?= esc(timeconverter(time())) ?></span></p>
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
            echo '<input type="file" name="foto" size="20">';
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
    var url = "<?= base_url('minta-surat/'); ?>";

    function mintaa() {
        var idjenis = document.getElementById('jenissuratid').value;
        console.log(idjenis);

        window.location.href = url + idjenis;
    }
</script>
<?= $this->endSection() ?>