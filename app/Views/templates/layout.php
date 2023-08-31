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
    <meta name="description" content="WebSite Surat Menyurat">
    <meta name="theme-color" content="light">
    <meta http-equiv="Cache-control" content="public">

    <title>
        <?= esc($titletext) ?>
    </title>

    <!-- global style -->
    <!-- <link rel="stylesheet" href="<?= base_url('/'); ?>css/style.css?max-age=315360"> -->
    <link rel="stylesheet" href="<?= base_url('/css/style.css'); ?>">

    <!-- font -->
    <link rel="preconnect" href="https://fonts.googleapis.com">
    <link rel="preconnect" href="https://fonts.gstatic.com" crossorigin>
    <link href="https://fonts.googleapis.com/css2?family=Ubuntu:wght@400;500;700&display=swap" rel="stylesheet">

    <!-- spesifik javascript Head -->
    <?= $this->renderSection('jsH') ?>

    <!-- spesifik style -->
    <?= $this->renderSection('style') ?>
</head>

<style>

</style>

<body>
    <!-- Navbar -->
    <?= $this->include('templates/navbar') ?>
    <!-- Dialog -->
    <?= view_cell('DialogMassageCell') ?>

    <!-- main data ada didalam side bar -->
    <?= $this->include('templates/sidebar') ?>
    <span style="display: none;" class="waktu-sekarang"></span>
</body>

<?= $this->renderSection('jsF') ?>

<!-- global JavaScript -->
<script>
    // !Jam ====================================================================
    const waktuElement = document.getElementsByClassName('waktu-sekarang')[0];

    function updateWaktu() {
        const now = new Date();

        const days = ['Minggu', 'Senin', 'Selasa', 'Rabu', 'Kamis', 'Jumat', 'Sabtu'];
        const day = days[now.getDay()];

        const months = [
            'Januari', 'Februari', 'Maret', 'April', 'Mei', 'Juni', 'Juli', 'Agustus', 'September', 'Oktober', 'November', 'Desember'
        ];
        const month = months[now.getMonth()];

        const date = now.getDate().toString().padStart(2, '0');
        const year = now.getFullYear();

        const hours = now.getHours().toString().padStart(2, '0');
        const minutes = now.getMinutes().toString().padStart(2, '0');
        const seconds = now.getSeconds().toString().padStart(2, '0');

        const waktuString = `${day}, ${date} ${month} ${year} ${hours}:${minutes}:${seconds}`;
        waktuElement.textContent = waktuString;
    }

    // Memanggil fungsi updateWaktu setiap 1 detik
    setInterval(updateWaktu, 1000);

    // Pertama kali memanggil fungsi untuk menampilkan waktu
    updateWaktu();


    // !Sidebar ================================================================
    const menu = document.getElementById('menu-label');
    const sidebar = document.getElementsByClassName('sidebar')[0];

    menu.addEventListener('click', function() {
        if (localStorage.getItem('sidebar') == 1) {
            localStorage.setItem('sidebar', '0');
        } else if (localStorage.getItem('sidebar') == 0) {
            localStorage.setItem('sidebar', '1');
        }
        sidebarClass();
    })

    function ceksidebar() {
        if (localStorage.getItem('sidebar') == 0) {
            autoCheck();
            sidebarClass();
        }
    }

    function sidebarClass() {
        if (!localStorage.getItem('sidebar')) {
            localStorage.setItem('sidebar', '1');
        }
        if (localStorage.getItem('sidebar') == 1) {
            sidebar.classList.remove('hide');
        } else {
            sidebar.classList.add('hide');
        }
    };

    function autoCheck() {
        var checkbox = document.getElementById("menu-checkbox");
        checkbox.checked = true;
    }
    ceksidebar();
</script>

</html>