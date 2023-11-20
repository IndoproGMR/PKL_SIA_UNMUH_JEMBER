<?php

use CodeIgniter\Model;

function replaceHolder($html, $json, $options = 1)
{
    foreach (json_decode($json, true) as $carikata => $gantikata) {

        $html = str_replace("{{{$carikata}}}", $gantikata, $html);
    }
    return $html;
}

function TandaTanganFormater($datapenanda)
{
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

    return $data;
    // d($data);
}
