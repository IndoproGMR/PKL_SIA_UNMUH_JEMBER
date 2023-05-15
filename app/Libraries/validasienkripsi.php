<?php

namespace App\Libraries;

use App\Libraries\enkripsi;

class validasienkripsi
{
    public function validasidariurl()
    {
        if (isset($_GET["validasi"]) && isset($_GET["noSurat"])) {
            $data    = $_GET["validasi"];
            $noSurat = $_GET["noSurat"];
            echo $this->validasiEnkrispsi($data, $noSurat);
        } else {
            echo "input error";
        }
    }
    public function jenisEnkripsi(String $data, String $noSurat)
    {
        $enkripsi = new enkripsi;
        $type = pecahkan($data);
        if (count($type) < 3) {
            echo "input error";
            return "error";
        }

        if ($type[0] == "DiTandaTanganiOleh") {
            return "Tanda Tangan";
            // return $this->validasiTTD($type[2], $noSurat);
        } elseif ($type[0] == "PDF") {
            return "File PDF";
            // return $this->validasiPDF();
        } else {
            return "error";
            // return "jenis validasi tidak di temukan";
        }
    }
    public function validasiEnkrispsi(String $data, String $noSurat)
    {
        $enkripsi = new enkripsi;
        $type = pecahkan($data);
        if (count($type) < 3 && count($type) > 1) {
            echo "input error";
            return "error";
        }


        if ($type[0] == "DiTandaTanganiOleh") {
            // return $this->validasiTTD($type[2], $noSurat);
            return $type;
        } elseif ($type[0] == "PDF") {
            // return $this->validasiPDF();
            return $type;
        } else {
            $type[0] = 'error';
            return  $type;
        }
    }

    public function validasiTTD(String $data, String $noSurat)
    {
        // TODO panggil Model yang memiliki datahash dengan noSurat yang sama
        if ($data) {
            $type[5] = "Valid";
            // return $type;
        }

        // TODO bila data dihash tidak ada di dalam DB maka dekripsikan hash nya
        $enkripsi = new enkripsi;

        $type = $enkripsi->dekripsiTTD($data);
        $type[5] = 'NotValid';

        if (count($type) < 5) {
            $type[5] = 'HashNotValid';
        }
        return $type;
    }


    public function validasiPDF()
    {
    }
}
