<!DOCTYPE html>
<html lang="en">

<head>
    <meta charset="UTF-8">
    <meta http-equiv="X-UA-Compatible" content="IE=edge">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>test template</title>
</head>

<style>
    /* body {
        width: 21.59cm;
        height: 27.94;
    } */

    .foto {
        width: 300px;
    }

    .qr {
        /* z-index: -1; */
        /* position: absolute; */
        left: 100px;
    }
</style>
<!-- <img src="qrcode/ini adalah nama qr.png" class="foto qr" alt=""> -->

<body>
    ini adalah web surat arsip
    <br>
    <!-- <img src="a" alt=""> -->

    <?= esc($datadaricontroller) ?>
    <br>
    <?= esc($datake2) ?>
    <?php

    use App\Libraries\Rendergambar;

    $Render = new Rendergambar;


    $Render->Render_gambar("$foto2", "foto qr");
    $Render->Render_gambar("logo/$foto1.png", "foto qr");
    $Render->Render_gambar("$foto3", "foto qr");
    // echo $_ENV['TTDKEY'];

    ?>
    <br>
</body>

</html>