<?php
$titletext = 'Surat';
if (!empty($title)) {
    $titletext = $title;
}
?>

<!DOCTYPE html>
<html lang="en">

<head>
    <!-- <?php header("Cache-Control: public, max-age=60, s-maxage=60", true, 200); ?> -->
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <meta name="description" content="WebSite Surat Menyurat">
    <meta name="theme-color" content="light">
    <meta http-equiv="Cache-control" content="public">

    <title>
        <?= esc($titletext) ?>
    </title>

    <!-- global style -->
    <link rel="stylesheet" href="<?= base_url('/css/root.css'); ?>">
    <link rel="stylesheet" href="<?= base_url('/css/style.css'); ?>">
    <link rel="stylesheet" href="<?= base_url('/css/style-form.css'); ?>">
    <link rel="stylesheet" href="<?= base_url('/css/style-sidebar.css'); ?>">

    <!-- font -->
    <link rel="preconnect" href="https://fonts.googleapis.com">
    <link rel="preconnect" href="https://fonts.gstatic.com" crossorigin>
    <link href="https://fonts.googleapis.com/css2?family=Ubuntu:wght@400;500;700&display=swap" rel="stylesheet">
    <!-- Global Script -->
    <!-- <script src="https://kit.fontawesome.com/a2450cb534.js" crossorigin="anonymous"></script> -->

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

    <!-- Start Sidebar -->
    <?= $this->include('templates/sidebar') ?>

    <!-- Start Main data -->
    <div class="kontenerutama">
        <?= $this->renderSection('main') ?>
    </div>

    <!-- END Main data -->

    </div>
    </div>
    <!-- End Sidebar -->

    <span style="display: none;" class="waktu-sekarang"></span>
</body>

<?= $this->renderSection('jsF') ?>

<!-- global JavaScript -->
<script>
    // bila filterquation tidak ada maka skip code ini
    var filterquation = document.getElementById('filterquation');

    // <div id="filterChackbox" style="display: block;">
    //         <label for="filterquation">Open Filter ?</label>
    //         <input type="checkbox" id="filterquation">
    // </div>

    // <div id="fiterKontener" style="display: none;">
    // code
    // </div>

    if (filterquation) {
        filterquation.addEventListener('click', function() {
            console.log('update');

            // tambahkan hidden
            document.getElementById('filterChackbox').style.display = 'none';

            // hapus hidden
            document.getElementById('fiterKontener').style.display = 'block';
        });
    }


    function consolwarning() {
        const mas = '⚠️ Warning: Anda Tidak Seharusnya Membuka Console';

        const styles = [
            'background-color: #ffc107',
            'color: #333',
            'font-size: 32px',
            'font-weight: bold',
            'padding: 8px',
            'border-radius: 4px',
        ];

        console.log(`%c${mas}`, styles.join(';'));
    }
    consolwarning();

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