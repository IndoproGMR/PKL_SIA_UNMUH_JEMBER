<?php

namespace App\Controllers;

use App\Controllers\BaseController;
use App\Libraries\enkripsi;
use App\Libraries\validasienkripsi;

class TestSuratmasuk extends BaseController
{
    public function index()
    {
        helper('form');
        $enkripsi = new enkripsi;

        $data['datadaricontroller'] = "controller";
        $data['datake2'] = "ini nomer 2";
        $data['foto1'] = "1513588325430";
        $data['foto2'] = "qrcode/ini adalah nama qr.png";
        $data['foto3'] = "qrcode/nama.png";

        $data['ttd'] = [
            [
                'tanggal' => "desember, 5 43 0201",
                'nama'    => "budi man 2",
                "lokasi"  => "qrcode/nama.png",
            ],
            [
                'tanggal' => "januari, 5 43 0201",
                'nama'    => "budi 2",
                "lokasi"  => "qrcode/ini adalah nama qr.png"
            ]
        ];

        $kata = 'Lorem ipsum dolor sit amet, consectetur adipiscing elit, sed do eiusmod tempor incididunt ut labore et dolore magna aliqua. Ut enim ad minim {{veniam}}, quis nostrud exercitation ullamco laboris nisi ut aliquip ex ea commodo consequat. {{data2}} aute irure dolor in reprehenderit in voluptate velit esse cillum dolore eu fugiat nulla pariatur. {{data1}} sint occaecat cupidatat non proident, sunt in culpa qui officia deserunt mollit anim id est laborum.';

        $katayangberubah = [
            [
                'carikata' => 'data1',
                'dengankata' => 'data satu berubah '
            ],
            [
                'carikata' => 'data2',
                'dengankata' => 'data dua berubah '
            ],
            [
                'carikata' => 'veniam',
                'dengankata' => 'ini juga berubah'
            ]
        ];

        $data['isi'] = replacetextarray($kata, $katayangberubah, '1');





        Render_pdf("test_suratmasuk", "01", "ini nama", $data);
        echo "<br>";



        // for ($i = 0; $i < 100; $i++) {

        echo $hasilhash = $enkripsi->enkripsiTTD("0912242", "035e29bb-c98e-40ec-b6a7-c5f1bc85aa20", "0312312", "nama", "23421232");
        echo "<br>";
        echo urlencode($hasilhash);
        echo "<br>";
        // }

        $enkripsi->generate_enkripsiQR("asd", "asd");
        Render_Qr($hasilhash, "nama");
        echo "<br>";



        $dataformjson2 = '[{"type":"text","name":"email","id":"1","value":"john1@example.com"},{"type":"text","name":"email","id":"2","value":"john12@example.com"}]';

        $dataformarray2 = json_decode($dataformjson2, true);


        // return view('test_suratmasuk', $data);

        // foreach ($dataformarray2 as $array2) {
        // d($array2);
        // echo form_input($array2);
        // }


        // $enkripsi->dekripsiTTD($hasilhash);
        return view('test_suratmasuk', $data);
    }





    public function validasi()
    {
        $validasienkripsi = new validasienkripsi();
        $validasienkripsi->validasidariurl();
        // return view("validasienkripsi");
    }
    public function kameraQR()
    {
        $data['nocam'] = false;

        if (isset($_GET["nocam"])) {
            $nocam = $_GET["nocam"];
            if ($nocam == "true") {
                $data['nocam'] = true;
            } else {
                $data['nocam'] = false;
            }
        }
        return view("kamerascan", $data);
    }
    public function detailSurat()
    {
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
