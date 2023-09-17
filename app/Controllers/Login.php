<?php

namespace App\Controllers;

use App\Controllers\BaseController;
use App\Libraries\enkripsi_library;


// $GLOBALS['loginUI'] = 'public';
$GLOBALS['loginUI'] = 'debug';

class Login extends BaseController
{

    // harus mahasiswa aktif
    public function index()
    {
        $session = \Config\Services::session();
        $session->destroy();

        helper('cookie');
        delete_cookie('API');

        $data['datacoba'] = [
            '1' => [
                'login' => 'yuni',
                'password' => '*FDF3D0567'
            ],
            '2' => [
                'login' => '99111084',
                'password' => '*6947C77DB'
            ],
            '3' => [
                'login' => 'yasin',
                'password' => '*30C2AA2CF'
            ],
            '4' => [
                'login' => '0000001',
                'password' => '*638F025EF'
            ],
            '5' => [
                'login' => '0001016602',
                'password' => '*3FB29F57B'
            ],
            '6' => [
                'login' => '1210652011',
                'password' => '*3E5287812'
            ],
            '7' => [
                'login' => generateIdentifier(16, 'time'),
                'password' => generateIdentifier()
            ],
        ];

        // d(user_id());
        // d(in_group("Mahasiswa"));
        // $model = model(Testusers::class);
        // $data['datalogin'] = $model->seeall();
        $data['defaultdata'] = '';

        if ($GLOBALS['loginUI'] == 'debug') {
            return view("login", $data);
        }
        return view("auth/Auth_login", $data);
        // return view("auth/Auth_login-figma", $data);
    }

    public function debuglogin()
    {
        $session = \Config\Services::session();
        $postdata = $this->request->getPost([
            'dataLogin',
            'dataPassword'
        ]);
        $model = model('AuthUserGroup');


        // ! Algoritma password
        /////
        // !



        if (!$model->proseslogin($postdata['dataLogin'], $postdata['dataPassword'])) {
            $session->destroy();
            return redirect()->to('error_perm');
        }

        $datauser = $model->cekuserinfo($postdata['dataLogin']);

        $data['userdata'] = [
            'id'       => $datauser['LoginUser'],
            'NamaUser' => $datauser['NamaUser'],
            'FotoUser' => $datauser['FotoUser'],
            'namaLVL'  => $datauser['namaLVL'],
            'Gelar'    => $datauser['Gelar']
        ];

        $session->set($data);

        // d($data);

        // return;
        return redirect()->to('/');
    }

    public function loginProses()
    {
        // $auth = new enkripsi_library;
    }

    public function logout()
    {
        $session = \Config\Services::session();
        $session->destroy();
        return redirect()->to('/login');
    }
}
