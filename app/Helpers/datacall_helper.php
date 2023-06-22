<?php
function datacallorder($pilihan)
{
    $isi = [
        "-order:waktu_ASC",
        "-order:waktu_DESC",
        "-order:nama_ASC",
        "-order:nama_DESC",
        "-order:email_ASC",
        "-order:email_DESC",
        "-order:gender_ASC",
        "-order:gender_DESC",
    ]; // 6

    $isi2 = [
        'ASC'    => 'ASC',
        'DESC'   => 'DESC',
        'NAMA'   => 'Name',
        'EMAIL'  => 'email',
        'GENDER' => 'gender',
        'WAKTU'  => 'waktu',
        'error'  => '',
    ];

    switch ($pilihan) {
        case '1':
            // untuk js
            $data = 'var data =' . json_encode($isi) . ';';
            break;
        case '2':
            // untuk php
            $data = $isi;
            break;
        case '3':
            $data = $isi2;
            break;
        default:
            $data = [''];
            break;
    }
    return $data;
}

function translateSanitasi($data)
{
    $trans = datacallorder(3);
    $data = strtoupper($data);
    return $trans[$data] ?? $trans['error'];
}

function quarytranslate($dataquary)
{
    // Membagi data menjadi dua bagian berdasarkan tanda "-"
    $parts = explode("-", $dataquary);

    // Mendapatkan elemen pertama yang berisi format order (misalnya "order:waktu_ASC")
    $orderPart = $parts[1];

    // Mendapatkan elemen kedua yang berisi opsi tambahan (misalnya "tahun>2010")
    $optionPart = $parts[2] ?? "";

    // Membagi format order menjadi dua bagian berdasarkan tanda ":"
    $orderParts = explode(":", $orderPart);

    // Mendapatkan jenis order (misalnya "waktu_ASC")
    $orderType = $orderParts[1];

    // Mengganti tanda "_" dengan spasi pada jenis order
    $orderType = str_replace("_", " ", $orderType);

    $orderOrder = explode(" ", $orderType);
    $orderOrder[0] = translateSanitasi($orderOrder[0]);
    $orderOrder[1] = translateSanitasi($orderOrder[1]);
    $orderType = implode(" ", $orderOrder);


    // Inisialisasi variabel opsi
    $orderString['options'] = '';
    $orderString['order'] = '';

    // Jika terdapat opsi tambahan
    if (!empty($optionPart)) {
        // Mencari tanda ">" pada opsi tambahan
        $greaterThanPos = strpos($optionPart, ">");

        // Mencari tanda "<" pada opsi tambahan
        $lowerThanPos = strpos($optionPart, "<");

        // Mencari tanda "=" pada opsi tambahan
        $sameThanPos = strpos($optionPart, "=");


        if ($greaterThanPos !== false) {
            // Mendapatkan bagian opsi sebelum tanda ">"
            $optionKey = substr($optionPart, 0, $greaterThanPos);

            // Mendapatkan bagian opsi setelah tanda ">"
            $optionValue = substr($optionPart, $greaterThanPos + 1);

            // Memodifikasi bagian opsi menjadi string yang lebih deskriptif
            $optionKey = str_replace("-", " ", $optionKey);

            // Menambahkan opsi ke string opsi tambahan
            $orderString['options'] =  translateSanitasi($optionKey) . " > " . $optionValue;
        }

        if ($lowerThanPos !== false) {
            // Mendapatkan bagian opsi sebelum tanda "<"
            $optionKey = substr($optionPart, 0, $lowerThanPos);

            // Mendapatkan bagian opsi setelah tanda "<"
            $optionValue = substr($optionPart, $lowerThanPos + 1);

            // Memodifikasi bagian opsi menjadi string yang lebih deskriptif
            $optionKey = str_replace("-", " ", $optionKey);

            // Menambahkan opsi ke string opsi tambahan
            $orderString['options'] =  translateSanitasi($optionKey) . " < " . $optionValue;
        }

        if ($sameThanPos !== false) {
            // Mendapatkan bagian opsi sebelum tanda "="
            $optionKey = substr($optionPart, 0, $sameThanPos);

            // Mendapatkan bagian opsi setelah tanda "="
            $optionValue = substr($optionPart, $sameThanPos + 1);

            // Memodifikasi bagian opsi menjadi string yang lebih deskriptif
            $optionKey = str_replace("-", " ", $optionKey);

            // Menambahkan opsi ke string opsi tambahan
            $orderString['options'] =  translateSanitasi($optionKey) . " = " . $optionValue;
        }
    }

    // Membuat string akhir untuk penggunaan dalam pernyataan SQL
    $orderString['order'] = "ORDER BY " . $orderType;

    return $orderString;
}
