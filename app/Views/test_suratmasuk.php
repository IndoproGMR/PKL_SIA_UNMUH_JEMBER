<?= $this->extend('surat/layout.php') ?>

<?= $this->section('main') ?>
ini adalah web surat arsip
<br>
<!-- <img src="a" alt=""> -->

<?= esc($datadaricontroller) ?>
<br>
<?= esc($datake2) ?>
<?php

use App\Libraries\Rendergambar;

$Render = new Rendergambar;
// echo esc($isi);
// d($ttd);
// foreach ($ttd as $ttdd) {
// d($ttdd);
// echo $ttdd['lokasi'];
// $Render->Render_gambar("$ttd1", "foto qr");
echo $this->include('surat/_ttd');
// echo $this->include('surat/_ttd');
// $Render->Render_TTD($ttdd['lokasi'], $ttdd);
// }



// $Render->Render_gambar("$foto2", "foto qr");
// $Render->Render_gambar("logo/$foto1.png", "foto qr");
// $Render->Render_gambar("$foto3", "foto qr");




?>

<br>
<a href="<?= base_url('pdf/test.pdf') ?>" target="_blank" rel="noopener noreferrer">pdf</a>
<br>
<?= $this->endSection() ?>