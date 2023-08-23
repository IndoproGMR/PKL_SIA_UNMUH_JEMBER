<select name="<?= esc($nameselect) ?>" id="<?= esc($idselect) ?>" <?php if (isset($onchange)) echo 'onchange="' . esc($onchange) . '"' ?>>

    <?php if (isset($firstoptions)) : ?>
        <option value="<?= esc($firstoptions['value']) ?>"><?= esc($firstoptions['name']) ?></option>
    <?php endif ?>

    <?php foreach ($options as $value) : ?>
        <option value="<?= esc($value['id']) ?>" <?= ($value['id'] == $selected) ? 'selected' : '' ?>>
            <?= esc($value['name']) ?>
        </option>
    <?php endforeach ?>

    <?php if (isset($lastoptions)) : ?>
        <option value="<?= esc($lastoptions['value']) ?>"><?= esc($lastoptions['name']) ?></option>
    <?php endif ?>
</select>