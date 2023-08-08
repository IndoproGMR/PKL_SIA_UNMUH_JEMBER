<?php

/**
 * masukan string text
 * cari kalimat yang ingin di ubah
 * options
 * 0 = tampah setting
 * 1 = {{$cariKata}}
 */
function replacetext(String $datatext, String $cariKata, String $denganKata, String $options)
{
    switch ($options) {
        case '1':
            $cariKata = "{{{$cariKata}}}";
            break;
        case '0':
            $cariKata = $cariKata;
            break;
        default:
            $cariKata = $cariKata;
            break;
    }
    return str_replace($cariKata, $denganKata, $datatext);
}

function potongString($inputString, $substring)
{
    $index = strpos($inputString, $substring);
    if ($index !== false) {
        return substr($inputString, $index + strlen($substring));
    } else {
        return $inputString;
    }
}

function replacetextarray($datatext, $cariKatadenganKata, String $options = '1')
{
    foreach ($cariKatadenganKata as $kata) {
        $datatext = replacetext($datatext, $kata['carikata'], $kata['dengankata'], $options);
    }
    return $datatext;
}

function ubahJSONkeSimpelJSON($json)
{
    $data = json_decode($json, true);

    $result = [];

    foreach ($data as $key => $value) {
        $prefix = substr($key, 0, strpos($key, '_'));

        if (!isset($result[$prefix])) {
            $result[$prefix] = [];
        }

        $result[$prefix][] = $value;
    }

    return json_encode($result);
}

function transformData($data)
{
    // $data = json_decode($jsonData, true);

    $ttd = [];

    foreach ($data['TTD'] as $value) {
        $ttdData = [
            'Status' => 0,
            'hash' => NULL,
            'TimeStamp' => 0,
            'SuratIdentifier' => $data['SuratIdentifier'],
            'jenisttd' => '', // Jenis TTD: Group atau Perorangan
            'pendattg_id' => '' // Nilai pendattg_id berdasarkan jenis TTD
        ];

        if (strpos($value, 'Group_') === 0) {
            $ttdData['jenisttd'] = 'Group';
            $ttdData['pendattg_id'] = substr($value, strlen('Group_'));
        } else if (strpos($value, 'Perorangan_') === 0) {
            $ttdData['jenisttd'] = 'Perorangan';
            $ttdData['pendattg_id'] = substr($value, strlen('Perorangan_'));
        }

        $ttd[] = $ttdData;
    }

    return $ttd;
}

function removeGroups($ttd)
{
    // Cari indeks elemen yang ingin dihapus
    $indexesToRemove = [];
    foreach ($ttd as $index => $value) {
        if ($value === 'Group_Mahasiswa' || $value === 'Group_Calon Mahasiswa') {
            $indexesToRemove[] = $index;
        }
    }

    // Hapus elemen dari array
    foreach ($indexesToRemove as $index) {
        unset($ttd[$index]);
    }

    // Reindex array setelah penghapusan elemen
    $ttd = array_values($ttd);


    return $ttd;
}

function pecahkan(String $text)
{
    return explode("_", $text);
}

function hash256($data, $length = 12)
{
    return substr(hash("sha256", $data), 0, $length);
}

function UUIDv4()
{
    // Generate 16 bytes (128 bits) of random uuidata or use the uuidata passed into the function.
    $uuidata = $uuidata ?? random_bytes(16);
    assert(strlen($uuidata) == 16);

    // Set version to 0100
    $uuidata[6] = chr(ord($uuidata[6]) & 0x0f | 0x40);
    // Set bits 6-7 to 10
    $uuidata[8] = chr(ord($uuidata[8]) & 0x3f | 0x80);

    // Output the 36 character UUID.
    return vsprintf('%s%s-%s-%s-%s-%s%s%s', str_split(bin2hex($uuidata), 4));
}


function SpaceToUnder($text)
{
    return str_replace(' ', '_', $text);
}

function UnderToSpace($text)
{
    return str_replace('_', ' ', $text);
}


function array_search_partial($arr, $keyword)
{
    foreach ($arr as $index => $string) {
        if (strpos($string, $keyword) !== FALSE)
            return $index;
    }
}

function inputform($dataformarray, $class = '')
{
    foreach ($dataformarray as $array) {
        echo form_input(
            esc($array),
            "",
            "placeholder=$array class='$class'"
        );
        echo "<br>";
    }
}

function ubaharray($array)
{
    $newArray = [];

    foreach ($array as $key => $value) {
        $newArray[] = [
            'carikata' => $key,
            'dengankata' => $value
        ];
    }
    return $newArray;
}

/**
 * $timestamp = unixTime
 * 
 * $jenis = default 'yunani'
 * yunani     = Monday, 03 July 2023 22:51:34
 * yunanitgl  = Monday, 03 July 2023
 * 
 * hijriah    = Monday, 14 Dhu al-Hijjah 1444 22:53:43
 * hijriahrgl = Monday, 14 Dhu al-Hijjah 1444
 */

function timeconverter(int $timestamp = 0, $jenis = 'yunani')
{
    // tgl hijriah
    date_default_timezone_set('Asia/Jakarta');
    $Arabic = new \ArPHP\I18N\Arabic();

    // tgl yunani
    $date = new DateTime("@$timestamp");
    $date->setTimezone(new DateTimeZone('GMT+7'));

    $Arabic->setDateMode(8);
    $correction = $Arabic->dateCorrection($timestamp);


    switch ($jenis) {
            // ! tanggal yunani
        case 'yunani':
            $data = $date->format('l, d F Y H:i:s');
            break;
        case 'yunanitgl':
            $data = $date->format('l, d F Y');
            break;

            // ! tanggal hijriah
        case 'hijriah':
            $data = $Arabic->date('l, j F Y H:i:s', $timestamp, $correction);
            break;
        case 'hijriahtgl':
            $data = $Arabic->date('l, j F Y', $timestamp, $correction);
            break;

            // ! error
        default:
            $data = 'jenis tanggal tidak ditemukan';
            break;
    }


    return $data;
}

function cekDir($dir)
{
    if (!is_dir($dir)) {
        mkdir($dir, 0777, TRUE);
        // cekDir($dir);
    }
    return $dir;
}

function cekFile($file)
{
    if (file_exists($file)) {
        return true;
    } else {
        return false;
    }
}

function generateIdentifier($length = 16)
{
    $timestamp = time();
    $timestampHex = dechex($timestamp);

    if (function_exists('random_bytes')) {
        $randomBytes = random_bytes($length - strlen($timestampHex) / 2);
    } elseif (function_exists('openssl_random_pseudo_bytes')) {
        $randomBytes = openssl_random_pseudo_bytes($length - strlen($timestampHex) / 2);
    } else {
        $randomBytes = '';
        for ($i = 0; $i < $length - strlen($timestampHex) / 2; $i++) {
            $randomBytes .= chr(mt_rand(0, 255));
        }
    }

    $randomHex = bin2hex($randomBytes);
    $identifier = $timestampHex . "-" . $randomHex;

    return substr($identifier, 0, $length);
}
