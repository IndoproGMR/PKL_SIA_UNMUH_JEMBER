<?php

namespace App\Libraries;

// render gambar
use App\Libraries\Rendergambar;
// validasi
use App\Libraries\validasienkripsi;
use App\Models\Jenissurat;
use App\Models\TandaTangan;

// full enkripsi berada di enkripsi_library

class enkripsi
{
    public function enkripsiTTD($noSurat, $idmhs)
    {
        $idPenandaTangan = userInfo()['id'];
        $NamaTTD         = userInfo()['NamaUser'];
        $RandomNumber    = random_int(00000000, 9999999);
        $unixtime        = time();

        $text = $noSurat     . "_" .
            $RandomNumber    . "-" .
            $unixtime        . "_" .
            $idPenandaTangan . "_" .
            $idmhs;
        $hasilhash = base64_encode($this->twowayhash_enkripsi($text));
        $textenkripsi = "DiTandaTanganiOleh_$NamaTTD" . "_" . $hasilhash;

        return $textenkripsi;
    }

    public function dekripsiTTD(String $text)
    {
        $datadekripsi = $this->twowayhash_dekripsi(base64_decode($text));
        return $this->pecahkan($datadekripsi);
    }

    public function twowayhash_enkripsi(String $msg)
    {
        $superkey = $_ENV["superKey"];
        $twowaykey = $_ENV["twoWAYKEY"];
        $algo = $_ENV["ALGO"];
        return openssl_encrypt($msg, $algo, $twowaykey, 0, $superkey);
    }

    public function twowayhash_dekripsi(String $msg)
    {
        $superkey = $_ENV["superKey"];
        $twowaykey = $_ENV["twoWAYKEY"];
        $algo = $_ENV["ALGO"];
        return openssl_decrypt($msg, $algo, $twowaykey, 0, $superkey);
    }


    ///
    function enkripsiPass()
    {
        //
    }

    function enkripsiToken()
    {
        //
    }

    ///
    function pecahkan(String $text)
    {
        return explode("_", $text);
    }
}
