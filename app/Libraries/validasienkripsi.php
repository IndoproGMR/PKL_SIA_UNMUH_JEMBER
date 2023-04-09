<?php

namespace App\Libraries;

use App\Libraries\enkripsi;

class validasienkripsi
{
    public function validasiEnkrispsi(String $data, String $noSurat)
    {
        $enkripsi = new enkripsi;
        $type = $enkripsi->pecahkan($data);

        $datahash = $type[2];
        if ($type[0] == "DiTandaTanganiOleh") {
            return $this->validasiTTD($datahash, $noSurat);
        } elseif ($type[0] == "PDF") {
            return $this->validasiPDF();
        } else {
            return "error";
        }
    }

    public function validasiTTD(String $data, String $noSurat)
    {
        // TODO panggil Model yang memiliki datahash dengan noSurat yang sama
        echo "</br>";
        echo $noSurat;
        echo "</br>";
        echo $data;
        echo "</br>";
        return "ada yang sama";
    }

    public function validasiPDF()
    {
    }
}
