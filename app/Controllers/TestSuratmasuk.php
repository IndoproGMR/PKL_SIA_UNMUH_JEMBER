<?php

namespace App\Controllers;

use App\Controllers\BaseController;
use App\Libraries\enkripsi;
use App\Libraries\validasienkripsi;
use App\Models\Isisurat;
use App\Models\Jenissurat;

class TestSuratmasuk extends BaseController
{
    public function index()
    {
        // $auth = ['Mahasiswa', 'Dosen'];
        // PagePerm($auth);
        PagePerm(['Mahasiswa', 'Dosen']);
        // PagePerm([]);
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





        Render_pdf("test_suratmasuk", "00", "ini nama", $data);
        echo "<br>";



        // for ($i = 0; $i < 100; $i++) {

        echo $hasilhash = $enkripsi->enkripsiTTD("0912242", "0312312", "nama", "23421232");
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

        foreach ($dataformarray2 as $array2) {
            d($array2);
            echo form_input($array2);
        }






        // $enkripsi->dekripsiTTD($hasilhash);
        return view('test_suratmasuk', $data);
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


    public function InputisiSurat()
    {

        $jenissurat = model(Jenissurat::class);
        $data['jenissurat'] = $jenissurat->seeall();



        return view('suratmasuk/inputisi', $data);
    }
    public function addisidata()
    {
        $postdata = $this->request->getPost([
            'isiDariSurat',
            'jenisSurat',
            'diskripsi',
            'csrf_test_name'
        ]);
        // $data['jumlah'] = $postdata['total'];


        $fielddata = $this->request->getPost();
        $json_data = SpaceToUnder(json_encode($fielddata));
        $dataformarray = json_decode($json_data, true);

        // d($data['json_data']);

        unset($dataformarray['isiDariSurat']);
        unset($dataformarray['jenisSurat']);
        unset($dataformarray['diskripsi']);
        unset($dataformarray['csrf_test_name']);

        $data['json_data'] = json_encode($dataformarray, true);

        $model = model(Isisurat::class);
        echo "inputing data";

        if ($model->addisiSurat($postdata['diskripsi'], $postdata['isiDariSurat'], $data['json_data'], $postdata['jenisSurat'])) {
            return redirect()->to('suratmasuk/inputisisurat');
        }

        // d($data['jsondata']);
        // d($data['json_data']);
        // d($dataformarray);
        // d($postdata);
        // d($fielddata);
        // d($data);
        // foreach ($dataformarray as $array) {
        //     // d($array2);

        //     echo form_input(
        //         esc($array),
        //         "",
        //         "placeholder=$array"
        //     );
        //     echo "<br>";
        // }
    }

    public function mintasuratindex()
    {
        $model = model(Jenissurat::class);
        $data['jenissurat'] = $model->seeall();
        return view('suratmasuk/mintasurat', $data);

        // d($model->seeall());
    }

    public function mintasurat(int $idsurat)
    {
        $model = model(Isisurat::class);
        echo $idsurat;
        $data['datasurat'] = $model->seebyjenis($idsurat);
        if (count($data) !== 1) {
            return redirect()->to('suratmasuk/mintasurat');
        }
        d(count($data));
        $data['dataform'] = json_decode($data['datasurat'][0]['form'], true);
        // if ($data['dataform']['foto']) {
        //     echo "ada foto";
        // }
        if (in_array("foto", $data['dataform'])) {
            unset($data['dataform']['foto']);
            $data['foto'] = 'foto';
        } else {
            echo "tidak ada foto";
        }
        d($data);


        // TODO membuat form input untuk meminta ttd
        // d($dataformarray);
        return view('suratmasuk/mintattd', $data);
    }

    public function addsuratmasuk($idsurat)
    {
        $model = model(Isisurat::class);
        echo $idsurat;
        $data['isisurat'] = $model->seebyjenis($idsurat)[0]['isiSurat'];
        $postdata = $this->request->getPost();

        $data['isi'] = replacetextarray($data['isisurat'], ubaharray($postdata), '1');






        d($postdata);
        d($data);
        d(ubaharray($postdata));
    }
}
