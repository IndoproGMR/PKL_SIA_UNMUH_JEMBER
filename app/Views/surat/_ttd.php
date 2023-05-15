<?php

// use App\Libraries\Rendergambar;

// $Render = new Rendergambar;

// d($ttd);
?>


<?php foreach ($ttd as $ttdd) : ?>
    <div>
        <?= $ttdd['tanggal'] ?>
        <br>
        <?php Render_gambar($ttdd['lokasi'], "fotottd"); ?>
        <?= $ttdd['nama'] ?>
    </div>
<?php endforeach ?>