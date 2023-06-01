<!DOCTYPE html>
<html lang="en">

<head>
    <meta charset="UTF-8">
    <meta http-equiv="X-UA-Compatible" content="IE=edge">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>mintasurat</title>
</head>

<body>
    <select name="jenissuratid" id="jenissuratid">
        <?php foreach ($jenissurat as $datajenis) : ?>
            <option value="<?= esc($datajenis['id']) ?>"><?= esc($datajenis['name']) ?></option>
        <?php endforeach ?>
    </select>
    <button onclick="mintaa()">
        minta surat
    </button>

    <!-- <button onClick="mintaa()">
        add input
    </button> -->

    <script>
        var url = "<?= base_url('suratmasuk/mintasurat/'); ?>"

        function mintaa() {
            var idjenis = document.getElementById('jenissuratid').value;
            console.log(idjenis);

            window.location.href = url + idjenis;
        }
    </script>
</body>

</html>