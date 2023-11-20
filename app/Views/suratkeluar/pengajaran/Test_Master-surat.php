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

<form class="inputform" action="<?= base_url('/Staff/Test-proses/Master-Surat'); ?>/<?= esc($id) ?>" method="get" id="inputisi" target="_blank">
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


    <br>

    <input type="submit" value="Test Surat">
</form>


<?= $this->endSection() ?>