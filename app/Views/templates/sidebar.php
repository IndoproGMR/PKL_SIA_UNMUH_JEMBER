<!-- Sidebar -->
<div class="containersidebar">

    <!-- sidebar bar -->
    <div class="sidebar">
        <div class="header">
            <div class="list-item ">
                <a href="<?= base_url('/'); ?>" class="linkSidebar">
                    <div class="fotouser">
                        <img src="https://sia.unmuhjember.ac.id/<?= esc(userInfo()['FotoUser']) ?>" alt="Foto Profile" class="" loading='lazy' onerror="this.src='<?= base_url('asset/logo/error_img.png') ?>';">
                    </div>
                    <p class="description-header"><?= esc(userInfo()['NamaUser']) ?> <?= esc(userInfo()['Gelar']) ?></p>
                </a>
            </div>
        </div>

        <div class="main">

            <?= view_cell(
                'SidebarLinkNotifCell',
                [
                    'linktext'  => 'Dashboard',
                    'imagelink' => 'asset/svg/house-solid.svg',
                    'shortcut'  => 'h'
                ]
            ) ?>

            <?php if (in_group(['Mahasiswa'])) : ?>

                <hr class="line">

                <?= view_cell(
                    'SidebarLinkNotifCell',
                    [
                        'link'      => 'Surat/Status-TandaTangan',
                        'linktext'  => 'Status Tanda Tangan',
                        'imagelink' => 'asset/svg/list-check-solid.svg',
                        'shortcut'  => ''
                    ]
                ) ?>

                <?= view_cell(
                    'SidebarLinkNotifCell',
                    [
                        'link'      => 'Surat/Minta-TandaTangan',
                        'linktext'  => 'Minta TandaTangan',
                        'imagelink' => 'asset/svg/pen-solid.svg',
                        'shortcut'  => ''
                    ]
                ) ?>


                <?= view_cell(
                    'SidebarLinkNotifCell',
                    [
                        'link'      => 'Surat/riwayat-Minta-TandaTangan',
                        'linktext'  => 'Riwayat Minta TandaTangan',
                        'imagelink' => 'asset/svg/clock-rotate-left-solid.svg',
                        'shortcut'  => ''
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

                <hr class="line">

                <?= view_cell(
                    'SidebarLinkNotifCell',
                    [
                        'link'      => 'Staff/Permintaan_TTD-Surat_Tanpa_NoSurat',
                        'linktext'  => 'Status Surat Yang Belum Punya No.',
                        'imagelink' => 'asset/svg/list-check-solid.svg',
                        'notif'     => $perluNoSurat,
                        'shortcut'  => ''
                    ]
                ) ?>

                <?= view_cell(
                    'SidebarLinkNotifCell',
                    [
                        'link'      => '/Staff/Master-Surat',
                        'linktext'  => 'Semua Master Surat',
                        'imagelink' => 'asset/svg/list-ul-solid.svg',
                        'notif'     => 0,
                        'shortcut'  => ''
                    ]
                ) ?>
                <?= view_cell(
                    'SidebarLinkNotifCell',
                    [
                        'link'      => '/input/master-surat',
                        'linktext'  => 'Tambah Master Surat',
                        'imagelink' => 'asset/svg/pen-solid.svg',
                        'shortcut'  => ''
                    ]
                ) ?>

                <hr class="line">

                <?= view_cell(
                    'SidebarLinkNotifCell',
                    [
                        'link'      => 'semua-archive-surat',
                        'linktext'  => 'Semua Archive Surat',
                        'imagelink' => 'asset/svg/server-solid.svg',
                        'shortcut'  => ''
                    ]
                ) ?>

                <?= view_cell(
                    'SidebarLinkNotifCell',
                    [
                        'link'      => 'input-archive-surat',
                        'linktext'  => 'Input Archive Surat',
                        'imagelink' => 'asset/svg/pen-solid.svg',
                        'shortcut'  => ''
                    ]
                ) ?>

                <hr class="line">

                <?= view_cell(
                    'SidebarLinkNotifCell',
                    [
                        // 'link'      => 'status-TTD',
                        'link'      => 'Surat_Perlu_TandaTangan',
                        'linktext'  => 'Status Tanda Tangan',
                        'imagelink' => 'asset/svg/signature-solid.svg',
                        'notif'     => $perluttd,
                        'shortcut'  => ''
                    ]
                ) ?>

                <?= view_cell(
                    'SidebarLinkNotifCell',
                    [
                        'link'      => 'Riwayat_TandaTangan',
                        'linktext'  => 'Riwayat Tanda Tangan',
                        'imagelink' => 'asset/svg/clock-rotate-left-solid.svg',
                        'notif'     => 0,
                        'shortcut'  => ''
                    ]
                ) ?>

                <hr class="line">

                <?= view_cell(
                    'SidebarLinkNotifCell',
                    [
                        'link'      => '',
                        'linktext'  => 'Query',
                        'imagelink' => 'asset/svg/database-solid.svg',
                        'shortcut'  => ''
                    ]
                ) ?>

                <hr class="line">

                <?= view_cell(
                    'SidebarLinkNotifCell',
                    [
                        'link'      => 'Admin-Panel',
                        'linktext'  => 'Admin Panel',
                        'imagelink' => 'asset/svg/user-gear-solid.svg',
                        'shortcut'  => ''
                    ]
                ) ?>
            <?php endif ?>

            <?php if (in_group(['Administrator'])) : ?>
                <hr class="line">

                <?= view_cell(
                    'SidebarLinkNotifCell',
                    [
                        'link'      => 'Admin-Panel',
                        'linktext'  => 'Admin Panel',
                        'imagelink' => 'asset/svg/user-gear-solid.svg',
                        'shortcut'  => ''
                    ]
                ) ?>
            <?php endif ?>


            <hr class="line">

            <?= view_cell(
                'SidebarLinkNotifCell',
                [
                    'link'      => 'qr-validasi',
                    'linktext'  => 'Cek Surat',
                    'imagelink' => 'asset/svg/qrcode-solid.svg',
                    'shortcut'  => 'g'
                ]
            ) ?>

            <?php if (in_group(['Mahasiswa'])) : ?>

                <?= view_cell(
                    'SidebarLinkNotifCell',
                    [
                        'link'      => 'help',
                        'linktext'  => 'Help',
                        'imagelink' => 'asset/svg/circle-info-solid.svg',
                        'shortcut'  => '?',
                        'target'    => '_blank'
                    ]
                ) ?>

            <?php endif ?>

            <?php if (in_group(['Dosen', 'Kepala Keuangan'])) : ?>

                <?= view_cell(
                    'SidebarLinkNotifCell',
                    [
                        'link'      => 'Staff/help',
                        'linktext'  => 'Help',
                        'imagelink' => 'asset/svg/circle-info-solid.svg',
                        'shortcut'  => '?',
                        'target'    => '_blank'
                    ]
                ) ?>

            <?php endif ?>


            <?= view_cell(
                'SidebarLinkNotifCell',
                [
                    'linkout'   => 'https://sia.unmuhjember.ac.id/',
                    'linktext'  => 'Sia Unmuh',
                    'imagelink' => 'asset/svg/globe-solid.svg',
                    'shortcut'  => '',
                    'target'    => '_blank'
                ]
            ) ?>

        </div>
        <br>
        <h5 class="Version">Web Version: Beta 0.6</h5>
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