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

<form class="inputform" action="<?= base_url('/Staff/test-proses/Master-Surat'); ?>" method="get" id="inputisi" target="_blank">
    <?= csrf_field() ?>
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
            <td><?= TombolTo('/staff/Preview/' . $datasurat['id'], 'Preview Surat', '', '_blank') ?></td>
        </tr>
    </table>


    <input hidden type="hidden" name="id" value="<?= esc($id) ?>">

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

    <input type="submit" value="Test Surat">
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