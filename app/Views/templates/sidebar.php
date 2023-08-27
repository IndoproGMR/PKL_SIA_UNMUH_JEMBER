<!-- Sidebar -->
<div class="containersidebar">

    <!-- sidebar bar -->
    <div class="sidebar">
        <div class="header">
            <div class="list-item">
                <a href="<?= base_url('/'); ?>" class="linkSidebar">
                    <img src="https://sia.unmuhjember.ac.id/<?= esc(userInfo()['FotoUser']) ?>" alt="Foto Profile" class="fotouser" loading='lazy'>
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
                        'link'      => 'status-surat',
                        'linktext'  => 'Status Tanda Tangan',
                        'imagelink' => 'asset/svg/list-status.svg',
                    ]
                ) ?>

                <?= view_cell(
                    'SidebarLinkNotifCell',
                    [
                        'link'      => 'minta-surat',
                        'linktext'  => 'Buat Surat',
                        'imagelink' => 'asset/svg/buat-surat.svg',
                    ]
                ) ?>


                <?= view_cell(
                    'SidebarLinkNotifCell',
                    [
                        'link'      => 'riwayat-surat',
                        'linktext'  => 'Riwayat',
                        'imagelink' => 'asset/svg/history.svg',
                    ]
                ) ?>
            <?php endif ?>


            <?php if (in_group(['Dosen', 'Kepala Keuangan'])) : ?>
                <?php
                $cache = \Config\Services::cache();
                $namacache = userInfo()['id'];

                if (cache($namacache . '_perluNoSuratC') === null) {
                    $model = model('SuratKeluraModel');
                    $perluNoSurat = count($model->seeAllnoNoSurat());
                    cache()->save($namacache . '_perluNoSuratC', $perluNoSurat, 30);
                }

                if (cache($namacache . '_TandaTanganc') === null) {
                    $model = model('TandaTangan');
                    $perluttd = count($model->cekStatusSuratTTD(userInfo()));
                    cache()->save($namacache . '_TandaTanganc', $perluttd, 30);
                }

                $perluNoSurat = cache($namacache . '_perluNoSuratC');
                $perluttd = cache($namacache . '_TandaTanganc');
                ?>

                <?= view_cell(
                    'SidebarLinkNotifCell',
                    [
                        'link'      => 'semua-surat-tanpa_NoSurat',
                        'linktext'  => 'Status Surat Yang belum punya No.',
                        'imagelink' => 'asset/svg/list-status.svg',
                        'notif'     => $perluNoSurat,
                    ]
                ) ?>

                <?= view_cell(
                    'SidebarLinkNotifCell',
                    [
                        'link'      => 'semua-surat',
                        'linktext'  => 'Semua Surat',
                        'imagelink' => 'asset/svg/list-menu.svg',
                        'notif'     => 0,
                    ]
                ) ?>

                <?= view_cell(
                    'SidebarLinkNotifCell',
                    [
                        'link'      => 'bikin-surat',
                        'linktext'  => 'Tambah Surat',
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
                        'link'      => 'status-TTD',
                        'linktext'  => 'Status Tanda Tangan',
                        'imagelink' => 'asset/svg/list-status.svg',
                        'notif'     => $perluttd,
                    ]
                ) ?>

                <?= view_cell(
                    'SidebarLinkNotifCell',
                    [
                        'link'      => 'riwayat-TTD',
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