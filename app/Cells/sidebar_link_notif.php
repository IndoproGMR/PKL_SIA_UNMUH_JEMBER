    <!-- Cek Status yang belum memiliki NoSurat -->
    <div class="list-item tooltip">
        <a href="<?= base_url("$link"); ?>" class="notification linkSidebar">
            <!-- <img src="<?= base_url("$imagelink"); ?>" alt="icon" class="icon" loading='lazy'> -->
            <img src="<?= base_url("$imagelink"); ?>" alt="icon" class="icon" loading='lazy'>
            <span class="description"><?= esc($linktext) ?></span>
            <!-- Notifikasi -->
            <?php if ($notif !== 0) : ?>
                <span class="badge"><?= esc($notif) ?></span>
            <?php endif ?>
        </a>
        <!-- ToolTip -->
        <span class="tooltiptext"><?= esc($linktext) ?></span>
    </div>