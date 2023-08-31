<!-- Navbar -->

<navbar>
    <div class="logo">
        <!-- <img src="<?= base_url('/'); ?>asset/logo/small/unmuh-tiny.png" alt="logo"> -->
        <img src="<?= base_url('/api/v1/image/logo'); ?>" alt="logo">
    </div>

    <div class="navbody">
        <div class="navbar">
            <p class="title one">Web Surat</p>
            <p class="title two">Universitas Muhammadiyah Jember</p>
        </div>
        <div class="navdesc">
            <h3><?= esc(userInfo()['NamaUser']) ?></h3>
            <p><?= esc(userInfo()['namaLVL']) ?></p>
            <p><a class="logout" href="<?= base_url('/login'); ?>">LogOut</a></p>
        </div>
    </div>
    <!-- <img src="asset/user-4-fill (3).svg" alt="" class="user"> -->
    <!-- <img src="https://sia.unmuhjember.ac.id/<?= esc(userInfo()['FotoUser']) ?>" alt="Foto Profile" class="userimg" loading='lazy'> -->
    <img src="https://sia.unmuhjember.ac.id/<?= esc(userInfo()['FotoUser']) ?>" alt="Foto Profile" class="fotouser" loading='lazy' onerror="this.src='asset/logo/error_img.png';">

</navbar>

<!-- End Navbar -->