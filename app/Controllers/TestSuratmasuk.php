<?php

namespace App\Controllers;

use App\Controllers\BaseController;
use App\Libraries\Rendergambar;
use App\Libraries\enkripsi;



class TestSuratmasuk extends BaseController
{
    public function index()
    {
        $enkripsi = new enkripsi;
        $Render = new Rendergambar;

        $Render->Render_pdf("test_suratmasuk", "01", "ini nama");
        // echo $text = "0912242_035e29bb-c98e-40ec-b6a7-c5f1bc85aa20-31235223_0312312_23421232_1680792515"; // contoh msg variable
        // echo "<br>";

        // echo $variableenkrip = $enkripsi->twowayhash_enkripsi($text);
        // echo "<br>";
        // echo $variableenkrip = "TTD-Oleh_nama Dosen_$variableenkrip";
        // echo $hashcode = $enkripsi->hash256($variableenkrip);
        // echo "<br>";
        // echo strlen($hashcode);
        // echo "<br>";
        // echo strlen($variableenkrip);
        // echo "<br>";

        // echo $enkripsi->twowayhash_dekripsi($variableenkrip);

        // $Render->Render_Qr($variableenkrip, "q392asd");

        return view('test_suratmasuk');
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
