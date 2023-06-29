<!DOCTYPE html>
<html lang="en">

<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Surat</title>
</head>

<style>

</style>

<body>
    <!-- START Kop Surat -->
    <?php if ($kop == 1) : ?>
        <?= $this->include('surat/_kopsurat1'); ?>
        <!-- kop surat 1 -->
    <?php elseif ($kop == 2) : ?>
        <?= $this->include('surat/_kopsurat2'); ?>
        <!-- kop surat 2 -->
    <?php else : ?>
        <?= $this->include('surat/_kopsurat'); ?>
        <!-- kop surat default -->
    <?php endif ?>
    <!-- END Kop Surat -->

    <!-- START isi Surat -->
    <?= $isi ?>
    <!-- END isi Surat -->
</body>

</html>