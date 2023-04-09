<?php

namespace App\Controllers;

use App\Controllers\BaseController;
use App\Libraries\Rendergambar;
use App\Libraries\enkripsi;
use App\Libraries\validasienkripsi;

class TestSuratmasuk extends BaseController
{
    public function index()
    {
        $enkripsi = new enkripsi;
        $Render = new Rendergambar;


        // $Render->Render_pdf("test_suratmasuk", "01", "ini nama");
        echo "<br>";


        // for ($i = 0; $i < 100; $i++) {

        echo $hasilhash = $enkripsi->enkripsiTTD("0912242", "035e29bb-c98e-40ec-b6a7-c5f1bc85aa20", "0312312", "nama", "23421232");
        echo "<br>";
        echo urlencode($hasilhash);
        // }

        $enkripsi->generate_enkripsiQR("asd", "asd");
        $Render->Render_Qr($hasilhash, "nama");
        echo "<br>";
        $Render->Render_gambar("qrcode/nama.png", "");
        // $enkripsi->dekripsiTTD($hasilhash);
        return view('test_suratmasuk');
    }

    public function validasi()
    {
        $validasienkrips = new validasienkripsi();
        if (isset($_GET["validasi"]) && isset($_GET["noSurat"])) {
            $data = $_GET["validasi"];
            $noSurat = $_GET["noSurat"];
            echo $validasienkrips->validasiEnkrispsi($data, $noSurat);
        } else {
            echo "input error";
        }

        echo "</br>";
    }
    public function kameraQR()
    {
        return view("validasienkripsi");
    }

    public function testreture($id)
    {
        return $id;
    }

    public function testreture2($id, $text)
    {
        return $id . " - " . $text . " - " . $_ENV['TTDKEY'];
    }
}
