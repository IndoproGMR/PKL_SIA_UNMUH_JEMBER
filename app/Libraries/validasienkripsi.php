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
    public function validasiEnkrispsi(String $data, String $noSurat)
    {
        $enkripsi = new enkripsi;
        $type = $enkripsi->pecahkan($data);
        if (count($type) < 3) {
            echo "input error";
            return "error";
        }

        echo "bruhh";
        if ($type[0] == "DiTandaTanganiOleh") {
            $datahash = $type[2];
            return $this->validasiTTD($datahash, $noSurat);
        } elseif ($type[0] == "PDF") {
            return $this->validasiPDF();
        } else {
            // echo "jenis validasi tidak di temukan";
            return "jenis validasi tidak di temukan";
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
        // TODO bila data dihash tidak ada di dalam DB maka dekripsikan hash nya
        $enkripsi = new enkripsi;
        $type = $enkripsi->dekripsiTTD($data);
        if (count($type) < 5) {
            echo "TTD tidak valid";
            return "";
        }
        echo "</br>";
        echo "NoSurat: " . $type[0]; // nosurat
        echo "</br>";
        echo "UUID: " . $type[1]; // datakosong
        echo "</br>";
        echo "Penandatangan: " . $type[2]; // penandatangan
        echo "</br>";
        echo "Mahasiswa: " . $type[3]; // mahasiswa
        echo "</br>";
        echo "timestamp: " . $type[4]; // kapan
        echo "</br>";

        // return "ada yang sama";
    }

    public function validasiPDF()
    {
    }
}
