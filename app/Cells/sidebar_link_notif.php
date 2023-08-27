    <!-- Cek Status yang belum memiliki NoSurat -->
    <div class="list-item">
        <a href="<?= base_url("$link"); ?>" class="notification linkSidebar">
            <img src="<?= base_url("$imagelink"); ?>" alt="icon" class="icon" loading='lazy'>
            <span class="description"><?= esc($linktext) ?></span>
            <?php if ($notif !== 0) : ?>
                <span class="badge"><?= esc($notif) ?></span>
            <?php endif ?>
        </a>
    </div>