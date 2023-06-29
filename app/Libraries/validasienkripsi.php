<?php

namespace App\Libraries;

use App\Libraries\enkripsi;
use App\Models\TandaTangan;

class validasienkripsi
{
    public function validasiTTD(String $data, String $noSurat)
    {
        helper('datacall');

        // !panggil Model yang memiliki datahash dengan noSurat yang sama
        $model = model(TandaTangan::class);
        $dataa['validasi'] = $model->cekvalidasi($noSurat, $data);

        // d($dataa['validasi']);
        if ($dataa['validasi']['NoSurat'] == $noSurat) {
            $dataa['validasi']['valid'] = 'TTD1';
            return $dataa['validasi'];
        }

        // !bila data dihash tidak ada di dalam DB maka dekripsikan hash nya
        $enkripsi_lib = new enkripsi_library;
        $dataa['hashraw'] = $this->pecahkan($data);
        $dataa['hash'] = $enkripsi_lib->dekripsiTTD($dataa['hashraw'][2]);
        if (count($dataa['hash']) > 2) {
            $dataa['validasi'] = [
                'NoSurat'     => $dataa['hash'][0],
                'TimeStamp'   => explode('-', $dataa['hash'][1])[1],
                'pendattg_id' => $dataa['hash'][2],
                'mshw_id'     => $dataa['hash'][3],
                'jenisSurat'  => datacallRespond('e'),
                'valid'       => 'TTD20'
            ];
            return $dataa['validasi'];
        }


        $dataa['validasi'] = [
            'NoSurat'     => datacallRespond('e'),
            'TimeStamp'   => datacallRespond('e'),
            'pendattg_id' => datacallRespond('e'),
            'mshw_id'     => datacallRespond('e'),
            'jenisSurat'  => datacallRespond('e'),
            'valid'       => 'TTD3'
        ];
        return $dataa['validasi'];
    }

    public function validasiPDF()
    {
    }

    ///
    function pecahkan(String $text)
    {
        return explode("_", $text);
    }
}
