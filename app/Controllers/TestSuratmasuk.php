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

        $data['datadaricontroller'] = "controller";
        $data['datake2'] = "ini nomer 2";
        $data['foto1'] = "1513588325430";
        $data['foto2'] = "qrcode/ini adalah nama qr.png";
        $data['foto3'] = "qrcode/nama.png";
        $Render->Render_pdf("test_suratmasuk", "00", "ini nama", $data);
        echo "<br>";


        // for ($i = 0; $i < 100; $i++) {

        echo $hasilhash = $enkripsi->enkripsiTTD("0912242", "035e29bb-c98e-40ec-b6a7-c5f1bc85aa20", "0312312", "nama", "23421232");
        echo "<br>";
        echo urlencode($hasilhash);
        echo "<br>";
        // }

        $enkripsi->generate_enkripsiQR("asd", "asd");
        $Render->Render_Qr($hasilhash, "nama");
        echo "<br>";

        // $enkripsi->dekripsiTTD($hasilhash);
        return view('test_suratmasuk');
    }

    public function validasi()
    {
        $validasienkripsi = new validasienkripsi();
        $validasienkripsi->validasidariurl();
        // return view("validasienkripsi");
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
