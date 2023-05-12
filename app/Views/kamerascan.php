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
        z-index: 1;
    }

    .container {
        position: relative;
    }

    .videogb {
        width: 300px;
        background-color: gray;
        padding: 20px;
        border-radius: 10px;
        z-index: -1;
    }

    .container video {
        position: relative;

    }

    .overlay {
        position: absolute;
        top: 50px;
        left: 50px;
        z-index: 0;
        background-color: red;
        border-radius: 20px;
        padding: 20px;
        font-size: larger;
    }
</style>

<body>

    <div class="container">
        <div class="videogb">
            <video id="preview"></video>
        </div>

        <div class="overlay">
            <p>Kamera sedang mati</p>
        </div>
    </div>
    <form action="" method="post">
        <input type="text" name="nosurat" id="nosurat" placeholder="NoSurat">
        <br>
        <textarea name="qrcode" id="qrcode" cols="30" rows="10"></textarea>
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
    } else {
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