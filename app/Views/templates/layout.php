<?php
$titletext = 'Surat';
if (!empty($title)) {
    $titletext = $title;
}
?>

<!DOCTYPE html>
<html lang="en">

<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">

    <title>
        <?= esc($titletext) ?>
    </title>

    <!-- global style -->
    <link rel="stylesheet" href="<?= base_url('/'); ?>css/style.css">

    <link rel="preconnect" href="https://fonts.googleapis.com">
    <link rel="preconnect" href="https://fonts.gstatic.com" crossorigin>
    <link href="https://fonts.googleapis.com/css2?family=Ubuntu:wght@400;500;700&display=swap" rel="stylesheet">

    <!-- spesifik javascript Head -->
    <?= $this->renderSection('jsH') ?>

    <!-- spesifik style -->
    <?= $this->renderSection('style') ?>
</head>

<style>
    .kontenerutama {
        padding: 15px;
    }
</style>

<body>
    <!-- Navbar -->
    <?= $this->include('templates/navbar') ?>

    <!-- main data ada didalam side bar -->
    <?= $this->include('templates/sidebar') ?>
</body>
<?= $this->renderSection('jsF') ?>
<script async src="<?= base_url('/'); ?>js/sidebarjs.js"></script>

</html>