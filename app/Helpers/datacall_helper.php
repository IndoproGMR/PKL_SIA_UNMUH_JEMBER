<?php
function datacallorder($pilihan)
{
    $isi = [
        "-order:waktu_ASC",
        "-order:waktu_DESC",
        "-order:name_ASC",
        "-order:name_DESC",
        "-order:harga_ASC",
        "-order:harga_DESC"
    ]; // 6

    switch ($pilihan) {
        case '1':
            // untuk js
            $data = 'var data =' . json_encode($isi) . ';';
            break;
        case '2':
            // untuk php
            $data = $isi;
            break;
        default:
            $data = [''];
            break;
    }
    return $data;
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

    // Inisialisasi variabel opsi
    $orderString['options'] = '';
    $orderString['order'] = '';

    // Jika terdapat opsi tambahan
    if (!empty($optionPart)) {
        // Mencari tanda ">" pada opsi tambahan
        $greaterThanPos = strpos($optionPart, ">");

        $lowerThanPos = strpos($optionPart, "<");

        $sameThanPos = strpos($optionPart, "=");


        if ($greaterThanPos !== false) {
            // Mendapatkan bagian opsi sebelum tanda ">"
            $optionKey = substr($optionPart, 0, $greaterThanPos);

            // Mendapatkan bagian opsi setelah tanda ">"
            $optionValue = substr($optionPart, $greaterThanPos + 1);

            // Memodifikasi bagian opsi menjadi string yang lebih deskriptif
            $optionKey = str_replace("-", " ", $optionKey);

            // Menambahkan opsi ke string opsi tambahan
            $orderString['options'] =  $optionKey . " > " . $optionValue;
        }

        if ($lowerThanPos !== false) {
            // Mendapatkan bagian opsi sebelum tanda "<"
            $optionKey = substr($optionPart, 0, $lowerThanPos);

            // Mendapatkan bagian opsi setelah tanda "<"
            $optionValue = substr($optionPart, $lowerThanPos + 1);

            // Memodifikasi bagian opsi menjadi string yang lebih deskriptif
            $optionKey = str_replace("-", " ", $optionKey);

            // Menambahkan opsi ke string opsi tambahan
            $orderString['options'] =  $optionKey . " < " . $optionValue;
        }

        if ($sameThanPos !== false) {
            // Mendapatkan bagian opsi sebelum tanda "="
            $optionKey = substr($optionPart, 0, $sameThanPos);

            // Mendapatkan bagian opsi setelah tanda "="
            $optionValue = substr($optionPart, $sameThanPos + 1);

            // Memodifikasi bagian opsi menjadi string yang lebih deskriptif
            $optionKey = str_replace("-", " ", $optionKey);

            // Menambahkan opsi ke string opsi tambahan
            $orderString['options'] = $optionKey . " = " . $optionValue;
        }
    }

    // Membuat string akhir untuk penggunaan dalam pernyataan SQL
    $orderString['order'] = "ORDER BY " . $orderType;

    return $orderString;
}
