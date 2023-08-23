<?php
d($dataterima);


?>
<?php if (isset($dataterima)) : ?>
    <div>
        <h1>Display Error ini berhasil dipanggil</h1>
        <span class='danger' style='color:#dc3545'>*
            <?php foreach ($dataterima as $value) : ?>
                <li><?= esc($value) ?></li>
            <?php endforeach ?>
        </span>
    </div>
<?php endif ?>