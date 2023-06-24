<?php

namespace App\Controllers;

use App\Controllers\BaseController;
use App\Libraries\enkripsi;
use App\Libraries\validasienkripsi;
use App\Models\Isisurat;
use App\Models\Jenissurat;
use App\Models\Suratmasuk;
use App\Models\TandaTangan;

class TestSuratmasuk extends BaseController
{
    public function index()
    {
        // $auth = ['Mahasiswa', 'Dosen'];
        // PagePerm($auth);
        PagePerm(['Mahasiswa', 'Dosen', 'Kepala Keuangan'], '/');
        // PagePerm(['' ]);
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





        // Render_pdf("test_suratmasuk", "00", "ini nama", $data);
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

    public function pdf()
    {

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

        // return view("test_suratmasuk", $data);
        // Render_pdf("test2_suratmasuk", "01", "ini nama", $data);
        Render_mpdf("test2_suratmasuk", "11", "ini nama", $data);
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
        // return view("suratmasuk/kameraqr", $data);
        return view("html5qrscanner", $data);
    }


    public function InputisiSurat()
    {
        // PagePerm(['Mahasiswa', 'Dosen']);

        $jenissurat = model(Jenissurat::class);
        $data['jenissurat'] = $jenissurat->seeall();
        $data['level'] = $jenissurat->seegrouplvl();
        $data['ttd'] = $jenissurat->seeNamaPettd();

        // d($data);

        return view('suratmasuk/inputisi', $data);
    }

    public function addisidata()
    {
        // PagePerm(['Mahasiswa', 'Dosen']);
        // PagePerm(['']);
        $postdata = $this->request->getPost([
            'isiDariSurat',
            'jenisSurat',
            'diskripsi',
            'csrf_test_name'
        ]);
        // $data['jumlah'] = $postdata['total'];

        d($postdata);
        $fielddata = $this->request->getPost();
        $json_data = json_encode($fielddata);
        $dataformarray = json_decode($json_data, true);

        d($fielddata);

        unset($dataformarray['isiDariSurat']);
        unset($dataformarray['jenisSurat']);
        unset($dataformarray['diskripsi']);
        unset($dataformarray['csrf_test_name']);

        $data['json_data'] = ubahJSONkeSimpelJSON(json_encode($dataformarray, true));

        d($data);

        $model = model(Jenissurat::class);
        echo "inputing data";



        if ($model->addJenisSurat($postdata['jenisSurat'], $postdata['diskripsi'], $postdata['isiDariSurat'], $data['json_data'])) {
            return redirect()->to('suratmasuk/inputisisurat');
        }
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
        $model = model(Jenissurat::class);
        $data['datasurat'] = $model->seebyID($idsurat);
        if (count($data) !== 1) {
            return redirect()->to('suratmasuk/mintasurat');
        }
        $data['dataform'] = json_decode($data['datasurat']['form'], true);
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

        foreach ($data['dataform']['TTD'] as $ii => $i) {
            echo $data['dataform']['TTD'][$ii];
            echo '<br>';
        }


        // TODO membuat form input untuk meminta ttd
        // d($dataformarray);
        return view('suratmasuk/mintattd', $data);
    }




    public function addmintasurat($idsurat)
    {
        helper(['text', 'date']);
        $model  = model(Suratmasuk::class);
        $model2 = model(TandaTangan::class);
        $model3 = model(Jenissurat::class);


        $postdata = $this->request->getPost();
        $json_data = json_encode($postdata);
        $dataformarray = json_decode($json_data, true);
        unset($dataformarray['csrf_test_name']);








        $data['NoSurat'] = random_string();
        $data['TimeStamp'] = now();
        $data['DataTambahan'] = base64_encode(json_encode($dataformarray));
        $data['JenisSurat_id'] = $idsurat;
        $data['mshw_id'] = userInfo()['id'];



        $TTDdata['TTD'] = json_decode($model3->seebyID($data['JenisSurat_id'])['form'], true)['TTD'];
        $TTDdata['NoSurat'] = $data['NoSurat'];
        $ttdArray = transformData($TTDdata);


        if ($model->addSuratMasuk($data)) {
            if ($model2->addTTD($ttdArray)) {
            }
        }
    }
}
