<!DOCTYPE html>
<html lang="en">

<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Surat</title>
</head>

<style>
    .konterner-utama {
        display: flex;
    }

    .konterner-persatuan-data {
        background-color: #ff0000;
        width: 200px;
        padding: 15px;
        margin: 15px;
    }

    table {
        width: 100%;
    }

    img {
        width: 100px;
        height: auto;

        /* aspect-ratio: 1; */
    }

    td {
        padding: 10px;
        /* background-color: #ff0000; */
        /* margin-bottom: 20px; */
        /* margin: 150px; */
    }

    .kontenerttd {
        padding: 5px;
        margin: 15px;
    }

    .centertext {
        text-align: center;
    }

    .underline {
        text-decoration: underline;
    }
</style>

<body>
    <!-- START Kop Surat -->
    <?php if ($kop == 1) : ?>
        <?= $this->include('surat/_kopsurat1'); ?>
        <!-- kop surat 1 -->
    <?php elseif ($kop == 2) : ?>
        <?= $this->include('surat/_kopsurat2'); ?>
        <!-- kop surat 2 -->
    <?php else : ?>
        <?= $this->include('surat/_kopsurat'); ?>
        <!-- kop surat default -->
    <?php endif ?>
    <!-- END Kop Surat -->

    <!-- START isi Surat -->
    <?= $isi ?>
    <!-- END isi Surat -->
    <!-- <pagebreak /> -->

    <?php
    $data = [
        0 => [
            'tgly'     => '7/6/2028',
            'tglh'     => '2/17/2097',
            'jabatan'  => 'dosen',
            'ttd'      => 'asset/logo/error_img.png',
            'nama'     => 'Carlos Chapman',
            'no'       => '466'
        ],
        1 => [
            'tgly'     => '9/14/2116',
            'tglh'     => '9/10/2108',
            'jabatan'  => 'dosen',
            'ttd'      => 'asset/logo/error_img.png',
            'nama'     => 'Estella McGuire',
            'no'       => '585'
        ],
        2 => [
            'tgly'     => '7/18/2032',
            'tglh'     => '9/8/2079',
            'jabatan'  => 'dosen',
            'ttd'      => 'asset/logo/error_img.png',
            'nama'     => 'Stanley Jimenez',
            'no'       => '456'
        ],
        3 => [
            'tgly'     => '4/19/2077',
            'tglh'     => '7/14/2047',
            'jabatan'  => 'dosen',
            'ttd'      => 'asset/logo/error_img.png',
            'nama'     => 'Shawn Watson',
            'no'       => '518'
        ],
        4 => [
            'tgly'     => '11/19/2070',
            'tglh'     => '12/6/2031',
            'jabatan'  => 'dosen',
            'ttd'      => 'asset/logo/error_img.png',
            'nama'     => 'Josie Wells',
            'no'       => '941'
        ],

    ];

    $index = 0;
    $perbaris = 2;

    ?>
    <div class="kontenerttd">
        <table>
            <?php foreach ($data as $key) : ?>
                <?php $index++ ?>

                <?php if ($index % $perbaris == 1) : ?>
                    <tr>
                    <?php endif ?>

                    <td class="centertext">
                        <p class="underline"><?= $key['tglh']; ?></p>
                        <p><?= $key['tgly']; ?></p>
                        <p><strong><?= $key['jabatan']; ?></strong></p>
                        <p><img src="<?= $key['ttd']; ?>" alt=""></p>
                        <p class="underline"><strong><?= $key['nama']; ?></strong></p>
                        <p><Strong><span>NIP/NPK : </span></Strong><span><?= $key['no']; ?></span></p>
                    </td>

                    <?php if ($index % $perbaris == 0) : ?>
                    </tr>
                <?php endif ?>

            <?php endforeach ?>
        </table>
    </div>


</body>

</html>


<!-- 
tanggal
Jabatan
TTD
nama
NPK / NIP

Mengetahui,
tanggal
Jabatan
TTD
nama 
-->