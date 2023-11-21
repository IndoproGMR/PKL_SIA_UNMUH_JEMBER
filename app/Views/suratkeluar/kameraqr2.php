<!DOCTYPE html>
<html lang="en">

<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <script src="<?= base_url('/js/html5-qrcode.min.js'); ?>"></script>
    <title>html5qrscanner</title>
</head>

<style>
    #reader {
        width: 300px;
        height: 300px;
    }
</style>

<body>
    <div id="reader"></div>





    <div class="vidcontainer">
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


    <br>
    <input type="submit" value="detail" onclick=detail(url_apidetail)>

    <br>

    <p class="detailhide">No Surat: <span id="no-surat"></span></p>
    <p class="detailhide">Mahasiswa: <span id="Mahasiswa"></span></p>
    <p class="detailhide">Penandatangan: <span id="Penandatangan"></span></p>
    <p class="detailhide">timestamp: <span id="timestamp"></span></p>
    <p class="detailhide">UUID: <span id="UUID"></span></p>




    <script>
        const url_api = "<?= base_url(getenv('urlapi'))  ?>";
        const url_apidetail = "<?= base_url(getenv('urlapi') . "/detail") ?>";
        <?php if (!$nocam) : ?>

            function onScanSuccess(decodedText) {
                // handle the scanned code as you like, for example:
                // console.log(`Code matched = ${decodedText}`, decodedResult);
                document.getElementById("qrcode").value = decodedText;

            }

            let html5QrcodeScanner = new Html5QrcodeScanner(
                "reader", {
                    fps: 10,
                    qrbox: {
                        width: 150,
                        height: 150
                    }
                },
                /* verbose= */
                false);


            // This method will trigger user permissions
            Html5Qrcode.getCameras()
                .then(devices => {
                    /**
                     * devices would be an array of objects of type:
                     * { id: "id", label: "label" }
                     */
                    if (devices && devices.length) {
                        var cameraId = devices[0].id;
                        // .. use this to start scanning.
                        console.log(devices);
                        console.log(cameraId);
                    }
                }).catch(err => {
                    // handle err
                });

            html5QrcodeScanner.render(onScanSuccess);

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