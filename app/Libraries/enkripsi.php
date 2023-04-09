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

    public function dekripsiTTD($text)
    {
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

    public function hash256($data)
    {
        return hash("sha256", $data);
    }

    public function UUIDv4()
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

    public function pecahkan(String $text)
    {
        return explode("_", $text);
    }

    public function generate_enkripsiQR(String $noSurat, String $idPenandaTangan)
    {
        // TODO ambil Hash Dari NoSurat dan nama PenandaTangan
        $data = "dataHashDariTTDSuratMasuk";
        $namaPenandatangan = "nama dari model";
        $namaFile = $noSurat . "_" . $namaPenandatangan;
        $Render = new Rendergambar;
        $Render->Render_Qr($data, $namaFile);
    }
}
