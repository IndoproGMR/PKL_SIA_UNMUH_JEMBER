<?php

namespace App\Controllers;

use App\Models\TandaTangan;

class Home extends BaseController
{
    public function index()
    {
        PagePerm([''], '/login', true);
        // return view('welcome_message');
        // return view('suratmasuk/status_surat');
        // $model = model(TandaTangan::class);
        // d($model->cekStatusSuratTTD('DveUCIo1', userInfo()));

        // d(userInfo());

        return view('home/index');
        // return view('auth/Auth_login');
        // return view('auth/Auth_register');
    }

    public function error_perm()
    {
        return view("auth/Auth_noPerm");
    }
}
