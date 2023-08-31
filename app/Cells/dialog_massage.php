<?php
if (FlashMassage('', '', '', 'get') === null) {
    return;
}

$type = FlashMassage('', '', '', 'get')['type'];
$massages = FlashMassage('', '', '', 'get')['massage'];
?>



<?php if ($type == 'fail') : ?>
    <div class="dialogContainer" style="display: block; background-color: #CF202A;">
    <?php elseif ($type == 'warning') : ?>
        <div class="dialogContainer" style="display: block; background-color: #E9D502;">
        <?php elseif ($type == 'success') : ?>
            <div class="dialogContainer" style="display: block; background-color: #8c8;">
            <?php else : ?>
                <div class="dialogContainer" style="display: block; background-color: gray;">
                <?php endif ?>
                <span class="closeDialog" onclick="this.parentElement.style.display='none';">&times;</span>
                <h3>List <?= esc($type) ?>:</h3>
                <ul>
                    <?php foreach ($massages as $massage) : ?>
                        <li><?= esc($massage) ?></li>
                    <?php endforeach ?>
                </ul>
                </div>