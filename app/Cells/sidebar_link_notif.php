<!-- Cek Status yang belum memiliki NoSurat -->
<div class="list-item tooltip">

    <?php if ($linkout == null || $linkout == '') : ?>
        <a href="<?= base_url("$link");  ?>" class="notification linkSidebar" target="<?= esc($target) ?>">

        <?php else : ?>
            <a href="<?= $linkout  ?>" class="notification linkSidebar" target="<?= esc($target) ?>">

            <?php endif ?>

            <img src="<?= base_url("$imagelink"); ?>" alt="icon" class="icon" loading='lazy'>
            <span class="description"><?= esc($linktext) ?></span>
            <!-- Notifikasi -->
            <?php if ($notif !== 0) : ?>
                <span class="badge bounce"><?= esc($notif) ?></span>
            <?php endif ?>
            </a>
            <!-- ToolTip -->
            <span class="tooltiptext"><?= esc($linktext) ?></span>
</div>

<?php if ($shortcut != '') : ?>
    <script>
        document.addEventListener('keydown', (e) => {
            if (e.key.toLowerCase() === "<?= esc($shortcut) ?>" && e.ctrlKey) {
                e.preventDefault();
                window.location = "<?= base_url("$link"); ?>";
            }
        });
    </script>
<?php endif ?>