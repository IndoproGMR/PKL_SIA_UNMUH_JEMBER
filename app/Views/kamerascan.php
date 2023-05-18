<!DOCTYPE html>
<html>

<head>
    <title>Instascan</title>
    <!-- <script type="text/javascript" src=" <?= base_url() ?>js/instascan.min.js"></script> -->
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

    .detailhide {
        display: none;
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
    <h1 id="valid"></h1>

    <input type="text" name="nosurat" id="nosurat" placeholder="NoSurat">
    <br>
    <textarea name="qrcode" id="qrcode" cols="30" rows="10"></textarea>
    <br>
    <input type="checkbox" name="autodetail" id="autodetail" value="autodetail"> auto detail
    <br>
    <?php if (!$nocam) : ?>
        <select name="kamera" id="kamera" onchange="jalankancamera()">
        </select>
    <?php else : ?>
        <select name="kamera" id="kamera">
            <option value="">camera has been disable</option>
        </select>
    <?php endif ?>


    <br>
    <input type="submit" value="detail" onclick=detail(url_apidetail)>

    <br>

    <p class="detailhide">No Surat: <span id="no-surat"></span></p>
    <p class="detailhide">Mahasiswa: <span id="Mahasiswa"></span></p>
    <p class="detailhide">Penandatangan: <span id="Penandatangan"></span></p>
    <p class="detailhide">timestamp: <span id="timestamp"></span></p>
    <p class="detailhide">UUID: <span id="UUID"></span></p>


    <script type="text/javascript">
        const url_api = "<?= base_url(getenv('urlapi'))  ?>";
        const url_apidetail = "<?= base_url(getenv('urlapi') . "/detail") ?>";

        <?php if (!$nocam) : ?>
            Instascan.Camera.getCameras().then(function(cameras) {
                if (cameras.length > 0) {
                    var selectopt = document.getElementById('kamera')
                    for (let index = 0; index < cameras.length; index++) {
                        const opt = document.createElement('option');
                        opt.value = index;
                        opt.textContent = cameras[index].name;
                        selectopt.appendChild(opt);
                    }
                    jalankancamera();
                } else {
                    const opt = document.createElement('option');
                    opt.value = 0;
                    opt.textContent = "No cameras found.";
                    selectopt.appendChild(opt);
                    console.error("No cameras found.");
                }
            }).catch(function(e) {
                console.error(e);
            });


            function jalankancamera() {
                let scanner = new Instascan.Scanner({
                    video: document.getElementById("preview")
                });
                scanner.addListener("scan", function(content) {
                    // console.log(content);
                    document.getElementById("qrcode").value = content;
                    cek(url_api)
                });


                var idcamera = document.getElementById('kamera').value;
                // console.log(idcamera);
                Instascan.Camera.getCameras().then(function(cameras) {
                    scanner.stop()
                    scanner.start(cameras[idcamera]);
                }).catch(function(e) {
                    console.error(e);
                });

            };

        <?php endif ?>

        async function cek(url) {
            var nosurat = document.getElementById("nosurat").value
            var qrcode = encodeURIComponent(document.getElementById("qrcode").value);
            url = url + "?nosurat=" + nosurat + "&qrcode=" + qrcode
            // console.log(url);
            var x = document.querySelector('#autodetail:checked');
            if (x) {
                detail(url_apidetail);
            }

            await fetch(url)
                .then((response) => {
                    return response.json();
                })
                .then((data) => {
                    var valid = document.getElementById("valid").textContent = data.valid;
                    console.log(data);
                })
        };

        function detail(url) {
            var nosurat = document.getElementById("nosurat").value
            var qrcode = encodeURIComponent(document.getElementById("qrcode").value);
            let countclass = document.getElementsByClassName("detailhide").length;

            deleteclass("detailhide", countclass);


            url = url + "?nosurat=" + nosurat + "&qrcode=" + qrcode

            fetch(url)
                .then((response) => {
                    return response.json();
                })
                .then((data) => {
                    var valid = data.valid;
                    console.log(valid);
                    document.getElementById("valid").textContent = data.valid;
                    document.getElementById("no-surat").textContent = data.nosurat;
                    document.getElementById("Mahasiswa").textContent = data.Mahasiswa;
                    document.getElementById("Penandatangan").textContent = data.Penandatangan;
                    document.getElementById("timestamp").textContent = data.timestamp;
                    document.getElementById("UUID").textContent = data.UUID;
                    // console.log(data);
                })
        };

        function deleteclass(namaclass, count) {
            if (!count == 0) {
                for (let index = 0; index < count; index++) {
                    document.getElementsByClassName(namaclass)[index].classList.remove(namaclass);
                    count = count - 1;
                }
                deleteclass(namaclass, count);
            }

        };
    </script>

</body>

</html>