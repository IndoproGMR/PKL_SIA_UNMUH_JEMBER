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
                    <img src="<?= base_url('/'); ?>asset/svg/home.svg" alt="" class="icon" loading='lazy'>
                    <span class="description">Dashboard</span>
                </a>
            </div>


            <?php if (in_group(['Mahasiswa'])) : ?>

                <!-- Cek QR -->
                <div class="list-item">
                    <a href="<?= base_url('/status-surat'); ?>">
                        <img src="<?= base_url('/'); ?>asset/svg/list-status.svg" alt="" class="icon" loading='lazy'>
                        <span class="description">Status</span>
                    </a>
                </div>

                <!-- Cek QR -->
                <div class="list-item">
                    <a href="<?= base_url('/minta-surat'); ?>">
                        <img src="<?= base_url('/'); ?>asset/svg/buat-surat.svg" alt="" class="icon" loading='lazy'>
                        <span class="description">Buat Surat</span>
                    </a>
                </div>

                <!-- Cek QR -->
                <div class="list-item">
                    <a href="<?= base_url('/riwayat-surat'); ?>">
                        <img src="<?= base_url('/'); ?>asset/svg/history.svg" alt="" class="icon" loading='lazy'>
                        <span class="description">Riwayat</span>
                    </a>
                </div>
            <?php endif ?>


            <?php if (in_group(['Dosen'])) : ?>

                <!-- list Surat semua surat -->
                <div class="list-item">
                    <a href="<?= base_url('/semua-surat'); ?>">
                        <img src="<?= base_url('/'); ?>asset/svg/list-menu.svg" alt="" class="icon" loading='lazy'>
                        <span class="description">Semua Surat</span>
                    </a>
                </div>

                <!-- bikin Surat -->
                <div class="list-item">
                    <a href="<?= base_url('/bikin-surat'); ?>">
                        <img src="<?= base_url('/'); ?>asset/svg/tambah.svg" alt="" class="icon" loading='lazy'>
                        <span class="description">Tambah Surat</span>
                    </a>
                </div>

                <!-- Surat masuk -->
                <div class="list-item">
                    <a href="<?= base_url('/bikin-surat'); ?>">
                        <img src="<?= base_url('/'); ?>asset/svg/tambah.svg" alt="" class="icon" loading='lazy'>
                        <span class="description">Tambah Surat Masuk</span>
                    </a>
                </div>

                <!-- Query  -->
                <div class="list-item">
                    <a href="<?= base_url('/bikin-surat'); ?>">
                        <img src="<?= base_url('/'); ?>asset/svg/tambah.svg" alt="" class="icon" loading='lazy'>
                        <span class="description">Query</span>
                    </a>
                </div>



                <!-- count untuk notip -->
                <?php
                $model = model(TandaTangan::class);
                $data['datasurat'] = $model->cekStatusSuratTTD(userInfo());
                $perluttd = count($data['datasurat']);
                ?>

                <!-- Cek Status yang belum TTD -->
                <div class="list-item">
                    <a href="<?= base_url('/status-TTD'); ?>" class="notification">
                        <img src="<?= base_url('/'); ?>asset/svg/list-status.svg" alt="" class="icon" loading='lazy'>
                        <span class="description">Status Tanda Tangan</span>
                        <?php if ($perluttd !== 0) : ?>
                            <span class="badge"><?= esc($perluttd) ?></span>
                        <?php endif ?>
                    </a>
                </div>

                <!-- Cek Riwayat yang sudah di TTDkan -->
                <div class="list-item">
                    <a href="<?= base_url('/riwayat-TTD'); ?>">
                        <img src="<?= base_url('/'); ?>asset/svg/history.svg" alt="" class="icon" loading='lazy'>
                        <span class="description">Riwayat Tanda Tangan</span>
                    </a>
                </div>

            <?php endif ?>




            <!-- Cek QR -->
            <div class="list-item">
                <a href="<?= base_url('/qr-validasi'); ?>">
                    <img src="<?= base_url('/'); ?>asset/svg/outline-qrcode.svg" alt="" class="icon" loading='lazy'>
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

        <!-- Start Main data -->
        <div class="kontenerutama">

            <?= $this->renderSection('main') ?>
        </div>
        <!-- END Main data -->

    </div>
</div>
<!-- End Sidebar -->