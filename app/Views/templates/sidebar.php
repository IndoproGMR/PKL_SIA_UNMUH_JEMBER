<!-- Siidebar -->

<div class="container">
    <div class="sidebar">
        <div class="header">
            <div class="list-item">
                <a href="">
                    <img src="https://sia.unmuhjember.ac.id/<?= esc(userInfo()['FotoUser']) ?>" alt="Foto Profile" class="icon" loading='lazy'>
                    <p class="description-header"><?= esc(userInfo()['NamaUser']) ?></p>
                </a>
            </div>
        </div>

        <div class="main">

            <!-- Cek QR -->
            <div class="list-item">
                <a href="<?= base_url(''); ?>">
                    <img src="<?= base_url('/'); ?>asset/home.svg" alt="" class="icon" loading='lazy'>
                    <span class="description">Dashboard</span>
                </a>
            </div>

            <?php if (in_group(['Mahasiswa'])) : ?>

                <!-- Cek QR -->
                <div class="list-item">
                    <a href="<?= base_url('/StatusSurat'); ?>">
                        <img src="<?= base_url('/'); ?>asset/list-status.svg" alt="" class="icon" loading='lazy'>
                        <span class="description">Status</span>
                    </a>
                </div>

            <?php endif ?>


            <?php if (in_group(['Dosen'])) : ?>

                <!-- Cek QR -->
                <div class="list-item">
                    <a href="<?= base_url('/StatusTTD'); ?>">
                        <img src="<?= base_url('/'); ?>asset/list-status.svg" alt="" class="icon" loading='lazy'>
                        <span class="description">Status TandaTangan</span>
                    </a>
                </div>

            <?php endif ?>


            <!-- Cek QR -->
            <div class="list-item">
                <a href="<?= base_url(''); ?>">
                    <img src="<?= base_url('/'); ?>asset/history.svg" alt="" class="icon" loading='lazy'>
                    <span class="description">Riwayat</span>
                </a>
            </div>

            <!-- Cek QR -->
            <div class="list-item">
                <a href="<?= base_url('/suratmasuk/kameraQR'); ?>">
                    <img src="<?= base_url('/'); ?>asset/outline-qrcode.svg" alt="" class="icon" loading='lazy'>
                    <span class="description">Cek Surat</span>
                </a>
            </div>

        </div>
    </div>
    <div class="main-content">

        <!-- Hamburger Menu -->
        <div id="menu-button">
            <input type="checkbox" id="menu-checkbox">
            <label for="menu-checkbox" id="menu-label">
                <div id="hamburger"></div>
            </label>
        </div>