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

    <?= timedecor() ?>
</div>


<div class="kontensurat">
    <h1><?= esc($datasurat['name']) ?></h1>
    <h3><?= esc($datasurat['description']) ?></h3>
    <h3><?= TombolTo('/staff/Preview/' . $datasurat['id'], 'Preview Surat', '', '_blank') ?></h3>
</div>


<form action="<?= base_url('/Staff/test-proses/Master-Surat'); ?>" method="get" id="inputisi" target="_blank">
    <?= csrf_field() ?>

    <input hidden type="text" name="id" value="<?= esc($id) ?>">
    <?php
    inputform($dataform['input']);
    ?>

    <br>
    <input type="submit" value="sumit">
</form>


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