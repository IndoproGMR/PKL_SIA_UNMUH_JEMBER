<?= $this->extend('templates/layout.php') ?>
<?= $this->section('style') ?>

<style>
    video {
        width: 300px;
        /* height: 300px; */
        /* overflow: hidden; */
        z-index: 1;
    }

    .vidcontainer {
        position: relative;
    }

    .videogb {
        width: 350px;
        background-color: gray;
        padding: 20px;
        border-radius: 10px;
        z-index: -1;
    }

    .vidcontainer video {
        position: relative;

    }

    .overlay {
        position: absolute;
        /* position: relative; */
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

<?= $this->endSection() ?>



<?= $this->section('main') ?>

<div class="vidcontainer">
    <div class="videogb">
        <video id="preview"></video>
    </div>

    <div class="overlay">
        <p>Kamera sedang mati</p>
    </div>
</div>
<h1 id="valid"> - </h1>

<input type="text" name="nosurat" id="nosurat" placeholder="NoSurat">
<br>
<br>
<textarea name="qrcode" id="qrcode" cols="30" rows="10"></textarea>
<br>
<br>
<?php if (!$nocam) : ?>
    <select name="kamera" id="kamera" onchange="setCamera(this.value)">
    </select>
    <button onclick="restartCamera()">Start Camera</button>
    <button onclick="stopcam()">Stop Camera</button>
<?php else : ?>
    <select name="kamera" id="kamera">
        <option value="">camera has been disable</option>
    </select>
    <button onclick="startCamera()">Start Camera</button>
<?php endif ?>

<br>
<br>
<input type="submit" value="detail" id="button_detail">
<br>

<?php if (!in_group(['Mahasiswa'])) : ?>

    <div>
        <p><input type="checkbox"> No Surat: <span id="no-surat"></span></p>
        <p><input type="checkbox"> Mahasiswa: <span id="Mahasiswa"></span></p>
        <p><input type="checkbox"> Penandatangan: <span id="Penandatangan"></span></p>
        <p><input type="checkbox"> timestamp: <span id="timestamp"></span></p>
        <p><input type="checkbox"> JenisSurat: <span id="JenisSurat"></span></p>
    </div>

    <input hidden type="text" id="inputNoSurat" name="noSurat">
    <input hidden type="text" id="inputMahasiswa" name="Mahasiswaat">

<?php else : ?>

    <div>
        <p>No Surat: <span id="no-surat"></span></p>
        <p>Mahasiswa: <span id="Mahasiswa"></span></p>
        <p>Penandatangan: <span id="Penandatangan"></span></p>
        <p>timestamp: <span id="timestamp"></span></p>
        <p>JenisSurat: <span id="JenisSurat"></span></p>
    </div>

<?php endif ?>


<?= $this->endSection() ?>

<?= $this->section('jsF') ?>
<!-- Js Script untuk Footer -->
<!-- <script type="text/javascript"> -->
<script>
    // import API_library from '<?= base_url('/js/API_library.js'); ?>';



    const url_api = "<?= base_url(getenv('urlapi') . '/validasi/qr')  ?>";
    const url_apidetail = "<?= base_url(getenv('urlapi') . "/validasi/qr/detail") ?>";

    <?php if (!$nocam) : ?> Instascan.Camera.getCameras()
            .then(function(cameras) {
                if (cameras.length > 0) {
                    var selectopt = document.getElementById('kamera')
                    for (let index = 0; index < cameras.length; index++) {
                        const opt = document.createElement('option');
                        opt.value = index;
                        opt.textContent = cameras[index].name;
                        selectopt.appendChild(opt);

                        var idcamera = document.getElementById('kamera').value;

                        if (localStorage.getItem('kameraID') == null) {
                            localStorage.setItem('kameraID', idcamera);
                        }
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
                document.getElementById("qrcode").value = content;
                detail(url_api)
            });

            var idcamera = localStorage.getItem('kameraID');

            Instascan.Camera.getCameras()
                .then(function(cameras) {
                    scanner.start(cameras[idcamera])
                        .then(() => {
                                console.log('Camera Ready');
                            },
                            () => {
                                localStorage.setItem('kameraID', 0);
                                window.location.reload();
                            })
                }).catch(function(e) {
                    console.error(e);
                });

        };

        function stopcam() {
            localStorage.setItem('kameraID', 0);
            window.location.href = "<?= base_url('/qr-validasi'); ?>?nocam=true";
        }


        function setCamera(id) {
            localStorage.setItem('kameraID', id);
        }

        function restartCamera() {
            window.location.reload();
        }

    <?php endif ?>

    function startCamera() {
        window.location.href = "<?= base_url('/qr-validasi'); ?>";
    }

    const tomboldetail = document.getElementById('button_detail');

    tomboldetail.addEventListener('click', () => {
        console.log('klick');
        detail();
    });

    function detail() {
        var nosurat = document.getElementById("nosurat").value
        var qrcode = encodeURIComponent(document.getElementById("qrcode").value);

        // const apilib = new API_library("<?= base_url(getenv('urlapi') . "/validasi/qr/detail") ?>");
        var urlq = url_apidetail + "?nosurat=" + nosurat + "&qrcode=" + qrcode;

        // apilib.setQuery(urlQ);
        // console.log(apilib.getURL());

        // var dataa;
        // await apilib.getRespond()
        //     .then(
        //         function(result) {
        //             return result;
        //         })
        //     .then(function(result) {
        //         dataa = result;
        //     });
        // console.log('respond succes: ', dataa);


        // return;
        fetch(urlq)
            .then((response) => {
                return response.json();
            })
            .then((data) => {
                document.getElementById("valid").textContent = data.valid;
                document.getElementById("no-surat").textContent = data.nosurat;
                document.getElementById("Mahasiswa").textContent = data.Mahasiswa;
                document.getElementById("Penandatangan").textContent = data.penandatangan;
                document.getElementById("timestamp").textContent = data.TimeStamp;
                document.getElementById("JenisSurat").textContent = data.JenisSurat;

                document.getElementById('inputNoSurat').value = data.nosurat;
                document.getElementById('inputMahasiswa').value = data.Mahasiswa;
            }).catch(function(error) {
                console.error("Terjadi kesalahan:", error);
            });

    };
</script>
<?= $this->endSection() ?>

<?= $this->section('jsH') ?>
<!-- Js Script untuk Header -->
<script type="text/javascript" src="https://cdnjs.cloudflare.com/ajax/libs/vue/2.1.10/vue.min.js"></script>

<script type="text/javascript" src="https://cdnjs.cloudflare.com/ajax/libs/webrtc-adapter/3.3.3/adapter.min.js"></script>

<script type="text/javascript" src="<?= base_url('/js/API_lib.js') ?>"></script>

<script type="text/javascript" src="https://rawgit.com/schmich/instascan-builds/master/instascan.min.js"></script>

<?= $this->endSection() ?>