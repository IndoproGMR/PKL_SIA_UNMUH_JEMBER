<?php

namespace App\Controllers;

use App\Models\TandaTangan;

class Home extends BaseController
{
    public function index()
    {
        PagePerm([''], '/login', true);

        // d(userInfo());


        // return view('suratmasuk/status_surat');
        // return view('welcome_message');
        // return view('auth/Auth_login');
        // return view('auth/Auth_register');
        return view('home/index');
    }

    public function error_perm()
    {
        return view("auth/Auth_noPerm");
    }
}
