<div>
    <form target="<?= esc($target) ?>" action="<?= base_url("$link"); ?>" method="<?= $method ?>" class="<?= $formclass ?>">

        <?= csrf_field() ?>
        <input type="text" name="<?= esc($nameinput) ?>" value="<?= esc($valueinput) ?>" hidden>

        <?php if ($confirmdialog) : ?>
            <input type="submit" value="<?= esc($textsubmit) ?>" class="<?= esc($tombolsubmitclass) ?>" onclick="return confirm('<?= esc($textConfirm) ?>');">
        <?php else : ?>
            <input type="submit" value="<?= esc($textsubmit) ?>" class="<?= esc($tombolsubmitclass) ?>">
        <?php endif ?>
    </form>
</div>