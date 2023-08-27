<!-- Navbar -->

<navbar>
    <div class="logo">
        <img src="<?= base_url('/'); ?>asset/logo/unmuh.png" alt="logo">
    </div>

    <div class="navbody">
        <div class="navbar">
            <h2 class="title-one">Web Surat</h2>
            <h2 class="title-two">Universitas Muhammadiyah Jember</h2>
        </div>
        <div class="navdesc">
            <h3><?= esc(userInfo()['NamaUser']) ?></h3>
            <p><?= esc(userInfo()['namaLVL']) ?></p>
            <p><a class="logout" href="<?= base_url('/login'); ?>">LogOut</a></p>
        </div>
    </div>
    <!-- <img src="asset/user-4-fill (3).svg" alt="" class="user"> -->
    <img src="https://sia.unmuhjember.ac.id/<?= esc(userInfo()['FotoUser']) ?>" alt="Foto Profile" class="userimg" loading='lazy'>
</navbar>

<!-- End Navbar -->