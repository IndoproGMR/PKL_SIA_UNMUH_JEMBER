<!DOCTYPE html>
<html>

<head>
    <title>Instascan</title>
    <!-- <script type="text/javascript" src="instascan.min.js"></script> -->
    <script type="text/javascript" src="https://cdnjs.cloudflare.com/ajax/libs/webrtc-adapter/3.3.3/adapter.min.js"></script>
    <script type="text/javascript" src="https://cdnjs.cloudflare.com/ajax/libs/vue/2.1.10/vue.min.js"></script>
    <script type="text/javascript" src="https://rawgit.com/schmich/instascan-builds/master/instascan.min.js"></script>
    <!-- <link rel="stylesheet" href="https://maxcdn.bootstrapcdn.com/bootstrap/3.4.1/css/bootstrap.min.css"> -->
</head>

<style>
    video {
        width: 300px;
    }
</style>

<body>
    <video id="preview"></video>
    <form action="" method="post">
        <input type="text" name="nosurat" id="nosurat" placeholder="NoSurat">
        <br>
        <input type="text" name="qrcode" id="qrcode" placeholder="QRcode">
        <input type="submit" value="cari">
    </form>
    <?php
    if (!$nocam) {
        echo '
        <script type="text/javascript">
        let scanner = new Instascan.Scanner({
            video: document.getElementById("preview")
        });
        scanner.addListener("scan", function(content) {
            console.log(content);
            document.getElementById("qrcode").value = content;
        });
        Instascan.Camera.getCameras().then(function(cameras) {
            if (cameras.length > 0) {
                scanner.start(cameras[0]);
            } else {
                console.error("No cameras found.");
            }
        }).catch(function(e) {
            console.error(e);
        });
    </script>
        ';
    }
    ?>
    <?php

    use App\Libraries\validasienkripsi;

    if (isset($_POST["nosurat"]) && isset($_POST["qrcode"])) {
        $nosurat = $_POST["nosurat"];
        $datahash = $_POST["qrcode"];
        $validasienkripsi = new validasienkripsi();
        $validasienkripsi->validasiEnkrispsi($datahash, $nosurat);
    }
    ?>

</body>

</html>