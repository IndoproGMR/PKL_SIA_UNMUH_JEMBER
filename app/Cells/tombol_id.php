<?php
$target = strtolower($target);
?>

<?php if ($method == 'redirect') : ?>

    <div>
        <a target="<?= esc($target) ?>" href="<?= base_url("$link"); ?>" class="<?= esc($tombolsubmitclass) ?>"><?= esc($textsubmit) ?>
        </a>
    </div>

<?php else : ?>

    <?php
    $identi = hash256(generateIdentifier(), '4');
    ?>

    <div>
        <form target="<?= esc($target) ?>" action="<?= base_url("$link"); ?>" method="<?= $method ?>" class="<?= $formclass ?>">
            <?= csrf_field() ?>
            <input type="hidden" name="<?= esc($nameinput) ?>" value="<?= esc($valueinput) ?>">

            <input type="submit" value="<?= esc($textsubmit) ?>" class="<?= esc($tombolsubmitclass) ?>" onclick="return runcommand<?= esc($identi) ?>(<?= $confirmdialog ? 'true' : 'false' ?>, '<?= esc($textConfirm) ?>')">
        </form>
    </div>

    <script>
        function runcommand<?= esc($identi) ?>(dialogbox, textdialog = 'Apakah Anda Yakin?') {
            if (dialogbox) {
                return confirm(textdialog);
            } else {
                <?php if ($target == '_blank') : ?>
                    if (true) {
                        setTimeout(function() {
                            window.location.reload();
                        }, 100);
                    }
                <?php endif ?>
            }
        }
    </script>
<?php endif ?>