<!-- Navbar -->

<navbar class="">

    <div class="logo">
        <img src="<?= base_url('/asset/logo/small/unmuh-tiny.png'); ?>" alt="logo" class="">
    </div>

    <div class="navbody">
        <div class="navbar">
            <p class="title">Web Surat</p>
            <p class="title">Universitas Muhammadiyah Jember</p>
        </div>
        <div class="navdesc">
            <h3><?= esc(userInfo()['NamaUser']) ?> <?= esc(userInfo()['Gelar']) ?></h3>
            <p><?= esc(userInfo()['namaLVL']) ?></p>
            <p><a class="logout" href="<?= base_url('/login'); ?>">LogOut</a></p>
        </div>
    </div>
    <!-- <img src="asset/user-4-fill (3).svg" alt="" class="user"> -->
    <!-- <img src="https://sia.unmuhjember.ac.id/<?= esc(userInfo()['FotoUser']) ?>" alt="Foto Profile" class="userimg" loading='lazy'> -->
    <div class="userimg ">
        <img src="https://sia.unmuhjember.ac.id/<?= esc(userInfo()['FotoUser']) ?>" alt="Foto Profile" class="" loading='lazy' onerror="this.src='<?= base_url('asset/logo/error_img.png') ?>';">
    </div>

</navbar>

<!-- End Navbar -->