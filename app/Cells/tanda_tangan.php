<?php
// $nomer = '123456'; // belum tau
// $nip = true;       // belum tau

// $jabatan = 'dosen';
// $nama = 'nama';

// $foto = 'asset/logo/error_img.png';
// $time = getUnixTimeStamp();

?>

<div class="">

    <p class="underline"><?= esc(timeconverter($time, 'hijriahtgl')) ?></p>
    <p><?= esc(timeconverter($time, 'yunanitgl')) ?></p>

    <p><strong><?= esc($jabatan) ?></strong></p>

    <p><img src="<?= esc($foto) ?>" alt=""></p>

    <p class="underline"><strong><?= esc($nama) ?></strong></p>

    <?php if ($nip) : ?>
        <p><Strong><span>NIP : </span></Strong><span><?= esc($nomer) ?></span></p>
    <?php else : ?>
        <p><Strong><span>NPK : </span></Strong><span><?= esc($nomer) ?></span></p>
    <?php endif ?>

</div>