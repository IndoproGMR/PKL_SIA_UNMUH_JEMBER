<?php

namespace App\Controllers;

use App\Controllers\BaseController;
use App\Libraries\enkripsi_library;


class Login extends BaseController
{

    // harus mahasiswa aktif
    public function index()
    {
        // !CLEAR AUTH
        delCacheData('AUTH_');

        $session = \Config\Services::session();
        $session->destroy();

        // !CLEAR Cookie
        helper('cookie');

        if (!is_null(get_cookie('API'))) {
            delCacheData(get_cookie('API'), '');
            delete_cookie('API');
        }
        // ! =================



        $data['defaultdata'] = '';

        if (env('AUTH_ENVIRONMENT') == 'development') {
            return view("login", $data);
        }
        return view("auth/Auth_login", $data);
        // return view("auth/Auth_login-figma", $data);
    }


    public function loginProses()
    {
        $session = \Config\Services::session();
        $postdata = $this->request->getPost([
            'dataLogin',
            'dataPassword'
        ]);




        // ! Algoritma password
        $encrip = new enkripsi_library();
        $hashpass = $encrip->enkripsiPass($postdata['dataPassword']);
        // !====================


        $model = model('AuthUserGroup');
        if (!$model->proseslogin(esc($postdata['dataLogin']), $hashpass)) {
            return redirect()->to('login');
        }

        $prefix = "AUTH_";
        if (cekCacheData($prefix, $postdata['dataLogin'])) {
            $datauser = $model->cekuserinfo($postdata['dataLogin']);
            setCacheData($prefix, $datauser, 18000, $postdata['dataLogin']);
        } else {
            $datauser = getCachaData($prefix, $postdata['dataLogin']);
        }


        $data['userdata'] = [
            'id'       => $datauser['LoginUser'],
            'NamaUser' => $datauser['NamaUser'],
            'FotoUser' => $datauser['FotoUser'],
            'namaLVL'  => $datauser['namaLVL'],
            'Gelar'    => $datauser['Gelar'],
            'IP'       => $this->request->getIPAddress()
        ];

        $session->set($data);
        return redirect()->to('/');
    }
}
