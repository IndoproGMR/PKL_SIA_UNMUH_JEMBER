<?php

use CodeIgniter\Model;

/**
 * Replaces placeholder text in an HTML string with values from a JSON object.
 *
 * @param string $html The HTML string containing placeholder text 
 * @param string $json The JSON string containing key/value pairs for replacement
 * 
 * @return string The HTML with placeholders replaced by values from the JSON
 */
function replaceHolder($html, $json)
{
    foreach (json_decode($json, true) as $carikata => $gantikata) {
        $html = str_replace("{{{$carikata}}}", $gantikata, $html);
    }

    helper('textsurat');
    $defaultText = [
        'NOW'   => getDateTime(),
        'TODAY' => getDateTime('date')

    ];

    foreach ($defaultText as $carikata => $gantikata) {
        $html = str_replace("{{{$carikata}}}", $gantikata, $html);
    }


    return $html;
}

/**
 * Formats data for generating PDF signatures.
 *
 * @param mixed $datapenanda Signature data 
 * 
 * @return array Formatted signature data
 */
function TandaTanganFormater($datapenanda)
{

    if (!is_string($datapenanda) && count($datapenanda) == 0) {
        $data['ttd'][0] = [
            'TimeStamp'   => 1,
            'path'        => 'asset/logo/unmuh.png',
            'NamaPenanda' => 'Nama' . " " . 'Gelar',
            'namaLVL'     => 'Pangkat',
            'NIDN'        => 1
        ];
    }

    // d($datapenanda);
    // !memasukan data penanda tangan ke dalam array
    $model3 = model('AuthUserGroup');

    if (is_array($datapenanda)) {
        foreach ($datapenanda as $key => $value) {
            $namapenanda = $model3->cekdoseninfo($value['pendattg_id']);

            // !Start cek bila foto qr ada di server
            $path = cekDir('uploads/QRcodeTTD/' . $value['pendattg_id']) . "/" . $value['qrcodeName'] . ".png";

            if (!cekFile($path)) {
                Render_Qr($value['hash'], $value['qrcodeName'], $value['pendattg_id']);
            }
            // !END

            $data['ttd'][$key] = [
                'TimeStamp'   => $value['updated_at'],
                'path'        => $path,
                'NamaPenanda' => $namapenanda['NamaUser'] . " " . $namapenanda['Gelar'],
                'namaLVL'     => $namapenanda['namaLVL'],
                'NIDN'        => $namapenanda['NIDN']
            ];
        }
        return $data;
    }
    $datapenanda =  json_decode($datapenanda, true)['TTD'];


    foreach ($datapenanda as $key => $value) {

        $infopenada = pecahkan($value);

        if ($infopenada[0] == 'Perorangan') {
            $namapenanda = $model3->cekdoseninfo($infopenada[1]);
        }

        if ($infopenada[0] == 'Group') {
            $namapenanda = [
                'namaLVL'  => $infopenada[1],
                'NamaUser' => $infopenada[1],
                'Gelar'    => '',
                'NIDN'     => $infopenada[1]
            ];
        }

        // if ($infopenada[0] != 'Perorangan' && $infopenada[0] !== 'Group') {
        //     # code...
        // }

        $data['ttd'][$key] = [
            'TimeStamp'   => 0,
            'path'        => 'asset/logo/unmuh.png',
            'NamaPenanda' => $namapenanda['NamaUser'] . " " . $namapenanda['Gelar'],
            'namaLVL'     => $namapenanda['namaLVL'],
            'NIDN'        => $namapenanda['NIDN']
        ];
    }
    // !END

    // d($data);
    // return;
    return $data;
}
