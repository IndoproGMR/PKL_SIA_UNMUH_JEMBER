<!DOCTYPE html>
<html lang="en">

<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Surat</title>
</head>

<style>
    .isi {
        margin-bottom: 20px;
    }

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
        border-spacing: 30px;
    }

    img {
        width: 150px;
        height: auto;

        /* aspect-ratio: 1; */
    }

    td {
        padding: 20px;
        /* background-color: red; */

        /* background-color: #ff0000; */
        /* margin-bottom: 20px; */
        /* margin: 150px; */
    }

    .kontenerttd {
        /* padding: 5px; */
        /* margin: 15px; */
    }

    .centertext {
        text-align: center;
    }

    .underline {
        /* color: red; */
        text-decoration: underline;
    }

    .ttdKontener {
        display: flex;
        /* background-color: red; */

    }

    .ttd {
        width: 200px;
        margin: 10px;
        /* background-color: green; */
    }
</style>

<body>

    <!-- START Kop Surat -->
    <?php

    if ($kop == 1) : ?>
        <!-- kop surat 1 -->
        <?= $this->include('surat/_kopsurat1'); ?>
    <?php elseif ($kop == 2) : ?>
        <!-- kop surat 2 -->
        <?= $this->include('surat/_kopsurat2'); ?>
    <?php else : ?>
        <!-- kop surat default -->
        <?= $this->include('surat/_kopsurat'); ?>
    <?php endif ?>
    <!-- END Kop Surat -->
    <p>No Surat: <span><?= esc($NoSurat) ?></span></p>



    <!-- START isi Surat -->
    <div class="isi">
        <?= $isi ?>
    </div>
    <!-- END isi Surat -->

    <?php
    // d($ttd);
    $index = 0;
    $perbaris = 2;

    ?>
    <div class="kontenerttd">
        <table>
            <?php foreach ($ttd as $key) : ?>
                <?php $index++ ?>

                <?php if ($index % $perbaris == 1) : ?>
                    <tr>
                    <?php endif ?>

                    <td class="centertext">
                        <?= view_cell('TandaTanganCell', [
                            'time' => $key['TimeStamp'],
                            'foto' => $key['path'],

                            'nama'    => $key['NamaPenanda'],
                            'jabatan' => $key['namaLVL'],

                            'nomer' => $key['NIDN'],
                        ]) ?>
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