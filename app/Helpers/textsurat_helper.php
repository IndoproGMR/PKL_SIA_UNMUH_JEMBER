<?php

use CodeIgniter\I18n\Time;

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



function replacetextarray($datatext, $cariKatadenganKata, String $options)
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
            'RandomStr' => NULL,
            'TimeStamp' => NULL,
            'NoSurat' => $data['NoSurat'],
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


function pecahkan(String $text)
{
    return explode("_", $text);
}

function hash256($data)
{
    return hash("sha256", $data);
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
    foreach ($dataformarray['input'] as $array) {
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

function timeconverter($timestamp = null)
{
    return Time::createFromTimestamp($timestamp, 'America/Chicago', 'en_US');
}
