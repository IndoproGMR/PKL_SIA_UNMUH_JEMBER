<?= $this->extend('templates/layout.php') ?>
<?= $this->section('style') ?>
<style>
    h1,
    h3 {
        text-align: center;
    }
</style>
<?= $this->endSection() ?>

<?= $this->section('main') ?>
<h1>Anda Dalam BlackList</h1>
<h3>Mohon Hubungi Staff</h3>
<br>
<br>
<p>Detail BlackList: <Span><?= esc($detailBL['description']) ?></Span></p>
<p>Kapan: <Span><?= esc(timeconverter($detailBL['UpdateTime'])) ?></Span></p>
<?= $this->endSection() ?>