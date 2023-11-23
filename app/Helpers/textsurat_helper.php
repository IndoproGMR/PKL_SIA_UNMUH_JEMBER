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
            'id'              => generateIdentifier(),
            'Status'          => 0,
            'hash'            => NULL,
            'SuratIdentifier' => $data['SuratIdentifier'],
            'jenisttd'        => '', // Jenis TTD: Group atau Perorangan
            'pendattg_id'     => '', // Nilai pendattg_id berdasarkan jenis TTD
            'created_at'      => getDateTime()
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

function hash256($data, $length = 64)
{
    if (is_array($data)) {
        return substr(hash("sha512", base64_encode(json_encode($data))), 0, $length);
    }

    return substr(hash("sha512", $data), 0, $length);
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



function cekDir($dir)
{
    if (!is_dir($dir)) {
        mkdir($dir, 0777, TRUE);
    }
    return $dir;
}

function cekFile($file)
{
    try {
        return file_exists($file);
    } catch (\Throwable $th) {
        return false;
    }
    return false;
}

function recursiveCopy($source, $destination)
{
    if (is_dir($source)) {
        if (!is_dir($destination)) {
            mkdir($destination, 0755, true);
        }

        $dirHandle = opendir($source);

        while (($file = readdir($dirHandle)) !== false) {
            if ($file != '.' && $file != '..') {
                $sourcePath = $source . '/' . $file;
                $destinationPath = $destination . '/' . $file;

                if (is_dir($sourcePath)) {
                    recursiveCopy($sourcePath, $destinationPath);
                } else {
                    if (!file_exists($destinationPath)) {
                        copy($sourcePath, $destinationPath);
                    }
                }
            }
        }

        closedir($dirHandle);

        return true;
    } else {
        return false;
    }
}

function copyFile($source, $destination)
{
    helper('filesystem');
    try {
        copy($source, $destination);
    } catch (\Throwable $th) {
        return false; // Gagal menyalin file
    }
    try {
        same_file($destination, $source);
    } catch (\Throwable $th) {
        return false; // file tidak sama
    }

    return true; // Berhasil menyalin file
}

function deleteFile($filePath)
{
    if (file_exists($filePath)) {
        if (unlink($filePath)) {
            return true; // Berhasil menghapus file
        } else {
            return false; // Gagal menghapus file
        }
    } else {
        return false; // File tidak ditemukan
    }
}

function moveFile($source, $destination)
{
    if (file_exists($source)) {
        if (rename($source, $destination)) {
            return true; // Berhasil memindahkan file
        } else {
            return false; // Gagal memindahkan file
        }
    } else {
        return false; // File sumber tidak ditemukan
    }
}

// !bug mengambil semua folder dari root (/) hingga folder web
// createZipFromFolder('../Z_Archice', '../Z_Archice.zip'); // contoh penggunaan

function createZipFromFolder($sourceFolder, $destinationZip)
{
    $zip = new ZipArchive();

    if ($zip->open($destinationZip, ZipArchive::CREATE | ZipArchive::OVERWRITE) === true) {
        $sourceFolder = realpath($sourceFolder);

        $iterator = new RecursiveIteratorIterator(
            new RecursiveDirectoryIterator($sourceFolder),
            RecursiveIteratorIterator::SELF_FIRST
        );

        foreach ($iterator as $file) {
            $file = realpath($file);

            if (is_dir($file)) {
                $zip->addEmptyDir(str_replace($sourceFolder . '/', '', $file . '/'));
            } elseif (is_file($file)) {
                $zip->addFile($file, str_replace($sourceFolder . '/', '', $file));
            }
        }

        $zip->close();

        return true;
    } else {
        return false;
    }
}


function getUnixTimeStamp()
{
    return strtotime(Time::now()->toDateTimeString());
}

function getDateTime()
{
    return Time::now()->toDateTimeString(); // out:"2023-11-05 15:38:22"
}

// !future proof sampai tahun 9999 atau upgrade Bahasa atau database :v
function generateIdentifier(int $length = 16)
{
    $timestamp = getDateTime();

    $timestampHex = $timestamp;
    $timestampHex = dechex(strtotime($timestamp));

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



/**
 * $timestamp = unixTime
 * 
 * $jenis = default 'yunani'
 * yunani     = Monday, 03 July 2023 22:51:34
 * yunanitgl  = Monday, 03 July 2023
 * 
 * hijriah    = Monday, 14 Dhu al-Hijjah 1444 22:53:43
 * hijriahtgl = Monday, 14 Dhu al-Hijjah 1444
 */

function timeconverter($timestamp = 0, $jenis = 'yunani')
{
    if ($timestamp == 0) {
        $timestamp = getUnixTimeStamp();
    }
    if (is_string($timestamp)) {
        try {
            $testString = strtotime($timestamp);
            $timestamp = strtotime($timestamp);
            $date = new DateTime("@$testString");
        } catch (\Throwable $th) {
            $timestamp = hexdec($timestamp);
        }
    }




    // tgl hijriah
    $Arabic = new \ArPHP\I18N\Arabic();


    $Arabic->setDateMode(8);
    $correction = $Arabic->dateCorrection($timestamp);

    // tgl yunani
    $date = new DateTime("@$timestamp");
    $date->setTimezone(new DateTimeZone('GMT+7'));

    $daysInIndonesian = [
        'Sunday'    => 'Minggu',
        'Monday'    => 'Senin',
        'Tuesday'   => 'Selasa',
        'Wednesday' => 'Rabu',
        'Thursday'  => 'Kamis',
        'Friday'    => 'Jumat',
        'Saturday'  => 'Sabtu'
    ];

    $monthsInIndonesia = [
        'January'   => 'Januari',
        'February'  => 'Februari',
        'March'     => 'Maret',
        'April'     => 'April',
        'May'       => 'Mei',
        'June'      => 'Juni',
        'July'      => 'Juli',
        'August'    => 'Agustus',
        'September' => 'September',
        'October'   => 'Oktober',
        'November'  => 'November',
        'December'  => 'Desember'
    ];

    $indonesianDay = $daysInIndonesian[$date->format('l')];
    $indonesianMonth = " " . $monthsInIndonesia[$date->format('F')] . " ";

    switch ($jenis) {
            // ! tanggal yunani
        case 'yunani':
            // $indonesianDay = $daysInIndonesian[$date->format('l')];
            // $indonesianMonth = " " . $monthsInIndonesia[$date->format('F')] . " ";
            $data = $indonesianDay . ', ' . $date->format('d') . $indonesianMonth . $date->format('Y H:i:s');
            break;
        case 'yunanitgl':
            // $indonesianDay = $daysInIndonesian[$date->format('l')];
            // $indonesianMonth = " " . $monthsInIndonesia[$date->format('F')] . " ";
            // $data = $indonesianDay . ', ' . $date->format('d F Y');
            $data = $indonesianDay . ', ' . $date->format('d') . $indonesianMonth . $date->format('Y');;
            break;

            // ! tanggal hijriah
        case 'hijriah':
            date_default_timezone_set('Asia/Jakarta');

            // $indonesianDay = $daysInIndonesian[$Arabic->date('l', $timestamp, $correction)];
            $data = $indonesianDay . $Arabic->date(', j F Y H:i:s', $timestamp, $correction);
            break;
        case 'hijriahtgl':
            date_default_timezone_set('Asia/Jakarta');

            // $indonesianDay = $daysInIndonesian[$Arabic->date('l', $timestamp, $correction)];
            $data = $indonesianDay . $Arabic->date(', j F Y', $timestamp, $correction);
            break;

            // ! error
        default:
            $data = 'jenis tanggal tidak ditemukan';
            break;
    }
    return $data;
}
