<!-- Sidebar -->
<div class="containersidebar">

    <!-- sidebar bar -->
    <div class="sidebar">
        <div class="header">
            <div class="list-item">
                <a href="<?= base_url('/'); ?>" class="linkSidebar">
                    <img src="https://sia.unmuhjember.ac.id/<?= esc(userInfo()['FotoUser']) ?>" alt="Foto Profile" class="fotouser" loading='lazy' onerror="this.src='asset/logo/error_img.png';">
                    <p class="description-header"><?= esc(userInfo()['NamaUser']) ?></p>
                </a>
            </div>
        </div>

        <div class="main">

            <?= view_cell(
                'SidebarLinkNotifCell',
                [
                    'linktext'  => 'Dashboard',
                ]
            ) ?>


            <?php

            if (in_group(['Mahasiswa'])) : ?>

                <?= view_cell(
                    'SidebarLinkNotifCell',
                    [
                        'link'      => 'Surat/Status-TandaTangan',
                        'linktext'  => 'Status Tanda Tangan',
                        'imagelink' => 'asset/svg/list-status.svg',
                    ]
                ) ?>

                <?= view_cell(
                    'SidebarLinkNotifCell',
                    [
                        'link'      => 'Surat/Minta-TandaTangan',
                        'linktext'  => 'Minta TandaTangan',
                        'imagelink' => 'asset/svg/buat-surat.svg',
                    ]
                ) ?>


                <?= view_cell(
                    'SidebarLinkNotifCell',
                    [
                        'link'      => 'Surat/riwayat-Minta-TandaTangan',
                        'linktext'  => 'Riwayat Minta TandaTangan',
                        'imagelink' => 'asset/svg/history.svg',
                    ]
                ) ?>
            <?php endif ?>


            <?php if (in_group(['Dosen', 'Kepala Keuangan'])) : ?>
                <?php
                $cache = \Config\Services::cache();
                $namacache = "notif_" . userInfo()['id'];

                if (cache($namacache) === null) {
                    $model1 = model('SuratKeluraModel');
                    $model2 = model('TandaTangan');

                    $cachedata['perluNoSurat'] = $model1->seeAllnoNoSuratCount();
                    $cachedata['perluttd']     = $model2->cekStatusSuratTTDCount(userInfo());

                    cache()->save($namacache, $cachedata, 30);
                }


                $perluNoSurat = cache($namacache)['perluNoSurat'];
                $perluttd     = cache($namacache)['perluttd'];
                ?>

                <?= view_cell(
                    'SidebarLinkNotifCell',
                    [
                        'link'      => 'Staff/Permintaan_TTD-Surat_Tanpa_NoSurat',
                        'linktext'  => 'Status Surat Yang belum punya No.',
                        'imagelink' => 'asset/svg/list-status.svg',
                        'notif'     => $perluNoSurat,
                    ]
                ) ?>

                <?= view_cell(
                    'SidebarLinkNotifCell',
                    [
                        'link'      => '/Staff/Master-Surat',
                        'linktext'  => 'Semua Master Surat',
                        'imagelink' => 'asset/svg/list-menu.svg',
                        'notif'     => 0,
                    ]
                ) ?>

                <?= view_cell(
                    'SidebarLinkNotifCell',
                    [
                        'link'      => '/input/master-surat',
                        'linktext'  => 'Tambah Master Surat',
                        'imagelink' => 'asset/svg/tambah.svg',
                        'notif'     => 0,
                    ]
                ) ?>

                <?= view_cell(
                    'SidebarLinkNotifCell',
                    [
                        'link'      => 'semua-archive-surat',
                        'linktext'  => 'semua archive Surat',
                        'imagelink' => 'asset/svg/list-menu.svg',
                        'notif'     => 0,
                    ]
                ) ?>

                <?= view_cell(
                    'SidebarLinkNotifCell',
                    [
                        'link'      => 'input-archive-surat',
                        'linktext'  => 'Input semua archive Surat',
                        'imagelink' => 'asset/svg/tambah.svg',
                        'notif'     => 0,
                    ]
                ) ?>

                <?= view_cell(
                    'SidebarLinkNotifCell',
                    [
                        'link'      => '',
                        'linktext'  => 'Query',
                        'imagelink' => 'asset/svg/tambah.svg',
                        'notif'     => 0,
                    ]
                ) ?>



                <?= view_cell(
                    'SidebarLinkNotifCell',
                    [
                        // 'link'      => 'status-TTD',
                        'link'      => 'Surat_Perlu_TandaTangan',
                        'linktext'  => 'Status Tanda Tangan',
                        'imagelink' => 'asset/svg/list-status.svg',
                        'notif'     => $perluttd,
                    ]
                ) ?>

                <?= view_cell(
                    'SidebarLinkNotifCell',
                    [
                        'link'      => 'Riwayat_TandaTangan',
                        'linktext'  => 'Riwayat Tanda Tangan',
                        'imagelink' => 'asset/svg/history.svg',
                        'notif'     => 0,
                    ]
                ) ?>

                <?= view_cell(
                    'SidebarLinkNotifCell',
                    [
                        'link'      => 'Admin-Panel',
                        'linktext'  => 'Admin Panel',
                        'imagelink' => 'asset/svg/history.svg',
                        'notif'     => 0,
                    ]
                ) ?>
            <?php endif ?>

            <?= view_cell(
                'SidebarLinkNotifCell',
                [
                    'link'      => 'qr-validasi',
                    'linktext'  => 'Cek Surat',
                    'imagelink' => 'asset/svg/outline-qrcode.svg',
                    'notif'     => 0,
                ]
            ) ?>

        </div>
    </div>

    <!-- main Conten -->
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