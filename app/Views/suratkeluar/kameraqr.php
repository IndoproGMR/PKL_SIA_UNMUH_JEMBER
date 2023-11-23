<?= $this->extend('templates/layout.php') ?>
<?= $this->section('jsH') ?>
<script src="https://unpkg.com/html5-qrcode" type="text/javascript"></script>
<script src="<?= base_url('/js/API_lib.js'); ?>" type="text/javascript"></script>
<?= $this->endSection() ?>


<?= $this->section('style') ?>
<style>
    input[type='text'] {
        height: 30px;
    }

    textarea {
        height: 80px;
    }




    /* input[type='button'] {
        background-color: red;
        width: 400px;
        height: 30px;

    } */


    input[type='text']:hover,
    textarea:hover {
        background-color: var(--clr-select-hover);
        border-radius: 3px;
    }

    input[type='text'],
    textarea {

        border-radius: 10px;
        border: 1px solid var(--clr-buttom);

        display: inline-block;
        text-decoration: none;
        font-size: 14px;
        padding: 5px 10px;
        margin: 5px 0px;
        font-weight: 500;

        width: 400px;
        transition: all ease-in-out 0.3s;
    }

    .kontenerInformasi {
        margin-top: 30px;
        width: 100%;
        /* background-color: #f00; */
        display: flex;
        justify-content: center;
        gap: 40px;
    }

    .InputQR {
        display: grid;
        justify-content: center;
        height: 600px;

        /* background-color: red; */
        /* background-color: rgb(218, 218, 218); */
        /* border-radius: 20px; */
    }

    .form {
        display: grid;
        justify-content: center;
        /* margin-top: 20px; */
    }


    #reader {
        width: 400px;
        height: 400px;

        border-radius: 20px;

    }


    .InformasiSurat {
        display: flex;
        flex-direction: column;
        align-items: center;
        justify-content: space-between;
        width: 400px;
        height: 600px;
        background-color: rgb(218, 218, 218);
        padding: 20px;
        /* Mengubah padding untuk memberi ruang lebih di sekitar elemen */
        border-radius: 20px;
        /* width: 400px;
        height: 600px;
        background-color: rgb(218, 218, 218);
        padding: 10px 20px;
        border-radius: 20px; */
    }


    h3 {
        text-align: center;
        margin-bottom: 10px;
        /* Memberi margin bawah pada h3 */
    }

    table {
        width: 100%;
        height: 400px;
    }



    td {
        padding: 10px;
        /* padding-bottom: 10px; */

    }


    div.InformasiSurat hr {
        margin-top: 10px;
        margin-bottom: 10px;
        width: 100%;
        border-color: #000;
    }

    a.Actions {
        width: 100%;
        text-align: center;
        bottom: 0px;
        align-self: flex-end;

    }

    /* Gaya tambahan untuk checkbox agar lebih terlihat baik */
    input[type="checkbox"] {
        transform: scale(1.5);
        /* Memperbesar ukuran checkbox */
        margin-top: 5px;
        /* Memberi margin atas pada checkbox */
    }
</style>
<?= $this->endSection() ?>

<?= $this->section('main') ?>
<div class="kontenerInformasi">

    <div class="InputQR">
        <div id="reader"></div>

        <div class="form">
            <input type="text" id="nosurat" placeholder="Nomer Surat">

            <textarea id="DataQRCode" placeholder="Data QRCode"></textarea>

            <input type="button" id="cekTTD" value="Cek TandaTangan" class="Actions">
        </div>
    </div>

    <div class="InformasiSurat">
        <h3>Cek Validasi</h3>
        <hr>
        <table>
            <tr>
                <td>
                    <strong>Nomer Surat:</strong>
                    <br>
                    <p id="NomerSurat">Nomer Surat:</p>
                </td>
                <td>
                    <input type="checkbox" class="CekBox">
                </td>
            </tr>

            <tr>
                <td>
                    <strong>Jenis Surat:</strong>
                    <br>
                    <p id="JenisSurat">Jenis Surat</p>
                </td>
                <td>
                    <input type="checkbox" class="CekBox">
                </td>
            </tr>

            <tr>
                <td>
                    <strong>Tanggal Meminta Surat:</strong>
                    <br>
                    <p id="TanggalMeminta">Tanggal Meminta Surat</p>
                </td>
                <td>
                    <input type="checkbox" class="CekBox">
                </td>
            </tr>

            <tr>
                <td>
                    <strong>PenandaTangan:</strong>
                    <br>
                    <p id="PenandaTangan">PenandaTangan</p>
                </td>
                <td>
                    <input type="checkbox" class="CekBox">
                </td>
            </tr>

            <tr>
                <td>
                    <strong>Mahasiswa:</strong>
                    <br>
                    <p id="Mahasiswa">Mahasiswa</p>
                </td>
                <td>
                    <input type="checkbox" class="CekBox">
                </td>
            </tr>
        </table>
        <hr>
        <h3 id="Valid">Unknown</h3>

        <a class="Actions" id="PreviewSurat" href="#" target="_blank">Preview Surat</a>
    </div>
</div>
<?= $this->endSection() ?>



<?= $this->section('jsF') ?>
<script>
    function onScanSuccess(decodedText, decodedResult) {
        // handle the scanned code as you like, for example:
        // console.log(`Code matched = ${decodedText}`, decodedResult);
        inputDataQRCode(decodedText);
    }

    // function onScanFailure(error) {
    //     // handle scan failure, usually better to ignore and keep scanning.
    //     // for example:
    //     console.warn(`Code scan error = ${error}`);
    // }

    let html5QrcodeScanner = new Html5QrcodeScanner(
        "reader", {
            fps: 10,
            qrbox: {
                width: 250,
                height: 250
            }
        },
        /* verbose= */
        false);
    html5QrcodeScanner.render(onScanSuccess);



    function inputDataQRCode(value) {
        document.getElementById('DataQRCode').textContent = value;
        detail();
    }

    var cekTTD = document.getElementById('cekTTD')

    function textLoading() {
        document.getElementById('NomerSurat').textContent = 'LOADING...';
        document.getElementById('JenisSurat').textContent = 'LOADING...';
        document.getElementById('TanggalMeminta').textContent = 'LOADING...';
        document.getElementById('PenandaTangan').textContent = 'LOADING...';
        document.getElementById('Mahasiswa').textContent = 'LOADING...';
        document.getElementById('Valid').textContent = 'LOADING...';
        document.getElementById('PreviewSurat').href = '#';
        cekTTD.value = 'LOADING...';

        // men uncheckBox semua yang memiliki class cekbox
        var checkboxes = document.getElementsByClassName('CekBox');

        for (var i = 0; i < checkboxes.length; i++) {
            checkboxes[i].checked = false;
        }
    }
    cekTTD.addEventListener('click', () => {
        console.log('test');
        textLoading();
        detail();
    });

    function detail() {
        textLoading();

        var nosurat = document.getElementById('nosurat').value;
        var DataQRCode = document.getElementById('DataQRCode').value;

        var url = "<?= base_url('/'); ?>" + '/api/v1/validasi/qr/detail?nosurat=' + nosurat + '&qrcode=' + DataQRCode;

        console.log(url);
        fetch(url)
            .then((response) => {
                return response.json();
            })
            .then((data) => {
                // console.log(data.result.nosurat);
                document.getElementById('NomerSurat').textContent = data.result.nosurat;
                document.getElementById('JenisSurat').textContent = data.result.JenisSurat;
                document.getElementById('TanggalMeminta').textContent = data.result.TimeStamp;
                document.getElementById('PenandaTangan').textContent = data.result.penandatangan;
                document.getElementById('Mahasiswa').textContent = data.result.Mahasiswa;
                document.getElementById('Valid').textContent = data.result.valid;
                cekTTD.value = 'Cek TandaTangan';

                if (data.result.nosurat == "Error") {
                    document.getElementById('PreviewSurat').href = '#';
                }

                document.getElementById('PreviewSurat').href = "<?= base_url('/Preview_Surat-TandaTangan/'); ?>" + data.result.nosurat;

            }).catch(function(error) {
                console.error("Terjadi kesalahan:", error);
            });

    }
</script>
<?= $this->endSection() ?>