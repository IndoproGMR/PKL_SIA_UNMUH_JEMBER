<!-- Navbar -->

<header>
    <div class="logo">
        <img src="<?= base_url('/'); ?>asset/Gambar1.png" alt="logo" class="image">
    </div>

    <div class="wrapper">
        <div class="navbar">
            <h1 class="title-one">Web Surat</h1>
            <h1 class="title-two">Universitas Muhammadiyah Jember</h1>
        </div>
        <div class="desc">
            <h1><?= esc(userInfo()['NamaUser']) ?></h1>
            <p><?= esc(userInfo()['namaLVL']) ?></p>
        </div>
    </div>
    <!-- <img src="asset/user-4-fill (3).svg" alt="" class="user"> -->
    <img src="https://sia.unmuhjember.ac.id/<?= esc(userInfo()['FotoUser']) ?>" alt="Foto Profile" class="user" loading='lazy'>
</header>

<!-- End Navbar -->