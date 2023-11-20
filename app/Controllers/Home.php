<?php

namespace App\Controllers;

use CodeIgniter\Cookie\Cookie;

class Home extends BaseController
{
    public function index()
    {
        PagePerm([''], '/login', true);

        if (!in_group(['Mahasiswa'])) {
            helper('cookie');

            // cek apakah browser memiliki cookie API
            if (is_null(get_cookie('API'))) {
                $pinAPI = hash256(generateIdentifier());

                $cookie = new Cookie(
                    'API',
                    $pinAPI,
                    [
                        'max-age' => 3600,
                    ]
                );

                // set ke browser
                set_cookie($cookie);
                // Set ke Redis

                if (!setCacheData($pinAPI, 'AUTH_API_X-Token', 3600, '')) {
                    return FlashMassage('/', ['API Key error']);
                }
            }
        }


        $prefix = "InformationsBoards";
        if (cekCacheData($prefix, '')) {
            $model = model("ServerConfig");
            $data['informations'] = $model->getServerConfig('informations');
            setCacheData($prefix, $data, 604800, '');
        } else {
            $data = getCachaData($prefix, '');
        }



        return view('home/index', $data);
    }

    public function StaffHelp()
    {
        echo 'StaffHelp';
    }

    public function MahasiswaHelp()
    {
        echo 'MahasiswaHelp';
    }

    // !Error Page
    public function error_perm()
    {
        return view('auth/Auth_noPerm');
    }

    public function CustomError()
    {
        return view('home/customError');
    }

    public function maintenance()
    {
        // return 'server in maintenance state';
        return view('home/Maintenance');
    }

    // ! TEST
    public function TestInfo()
    {

        // d(getUnixTimeStamp());
        // d(getDateTime());
        // d(generateIdentifier());
        // d(strtotime("9999-12-30 23:59:59"));
        // d(timeconverter(0, 'hijriah'));

        // d(getToken());
        // $data['nomerSurat'] = 2342;
        // $data['nama Mahasiswa'] = 'YES';
        // d(ApiStandarisasi($data, 'success', 200, true));
        // d(ApiStandarisasi($data, 'success', 200));

        // return $this->response->setJSON(ApiStandarisasi($data));

        // d($this->request->getIPAddress());


        // d(FCPATH);
        // $text = 'TTD.valid.t.n.exist.db.!2';
        // $data = 'Tanda Tangan Tidak ada Didalam Database!!!';

        // $text = 'TTD.n.exist.db';
        // d(resMas($text));
        // d($text);
        // d(FlashMassage('', '', '', 'get'));
        // d(FlashMassage('', '', '', 'get')['massage']);
        // d(FlashMassage('', '', '', 'get')['type']);

        // $jenissurat = model(Jenissurat::class);
        // $data['level'] = $jenissurat->seegrouplvl();
        // $data['ttd'] = $jenissurat->seeNamaPettd();
        // return view('suratKeluar/pengajaran/input_master-surat', $data);
    }

    public function TestInfoProses()
    {
        $postdatasurat = $this->request->getPost(
            [
                'inputisi',
                'jenisSurat',
                'diskripsi',
            ]
        );
        // d($postdatasurat);

        $postdataform = $this->request->getPost(
            [
                'input',
                'tambahan',
                'TTD'
            ]
        );
        // d($postdata);

        $dataerror = null;
        foreach ($postdatasurat as $key => $value) {
            $validationRule = Validasi_Input($key);
            // !ganti php.ini untuk menambah upload limit

            if (!$this->validate($validationRule)) {
                $dataerror = $this->validator->getErrors();
            }
        }

        if (!$dataerror == null) {
            return FlashMassage('/', $dataerror, 'warning');
        }

        // d($data);


        foreach ($postdataform as $key => $value) {
            if ($value == null) {
                unset($postdata[$key]);
            }
        }

        d($postdataform);
        d(json_encode($postdataform));
    }

    public function TestInfoput()
    {
        $data = [
            'test 1',
            'test 2',
        ];
        return FlashMassage('/', $data, 'success');
    }
}
