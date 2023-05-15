<?php foreach ($ttd as $ttdd) : ?>
    <div class="g-col-6">
        <span class="tgl"><?= $ttdd['tanggal'] ?></span>

        <br>
        <?php Render_gambar($ttdd['lokasi'], "fotottd"); ?>
        <br>

        <span class="nama"><?= $ttdd['nama'] ?></span>

    </div>
    <br>
<?php endforeach ?>