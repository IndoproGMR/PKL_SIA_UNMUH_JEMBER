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

            if (is_null(get_cookie('API'))) {

                $pinAPI = hash256(generateIdentifier(), 64);

                $cookie = new Cookie(
                    'API',
                    $pinAPI,
                    [
                        'max-age' => 3600 * 3,
                    ]
                );
                set_cookie($cookie);

                $model2 = Model('TempPin');
                if (!$model2->buatPinAPI($pinAPI)) {
                    FlashMassage('/', ['API Key error']);
                }
            }
        }

        return view('home/index');
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

    public function TestInfo()
    {
        d($this->request->getIPAddress());


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
