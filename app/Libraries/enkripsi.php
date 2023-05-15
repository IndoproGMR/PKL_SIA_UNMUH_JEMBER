<?php

namespace App\Libraries;

// render gambar
use App\Libraries\Rendergambar;
// validasi
use App\Libraries\validasienkripsi;

class enkripsi
{
    public function enkripsiTTD(String $noSurat, String $UUID, String $idsiapayangttd, String $NamaTTD, String $idmhs)
    {
        $RandomNumber = random_int(00000000, 9999999);
        $unixtime = time();
        $text = $noSurat . "_" .  $RandomNumber . "-" . $UUID . "_" . $idsiapayangttd . "_" . $idmhs . "_" . $unixtime;
        $textenkripsi = "DiTandaTanganiOleh_$NamaTTD" . "_" . $this->twowayhash_enkripsi($text);
        // TODO panggil model untuk menyimpan data

        return $textenkripsi;
    }

    public function dekripsiTTD(String $text)
    {
        $datadekripsi = $this->twowayhash_dekripsi($text);
        return pecahkan($datadekripsi);
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


    public function generate_enkripsiQR(String $noSurat, String $idPenandaTangan)
    {
        // TODO ambil Hash Dari NoSurat dan nama PenandaTangan
        $data = "dataHashDariTTDSuratMasuk";
        $namaPenandatangan = "nama dari model";
        $namaFile = $noSurat . "_" . $namaPenandatangan;
        Render_Qr($data, $namaFile);
    }
}
