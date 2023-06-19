<?php

namespace App\Controllers;

class Home extends BaseController
{
    public function index()
    {
        // return view('welcome_message');
        // return view('suratmasuk/status_surat');
        return view('home/index');
        // return view('auth/Auth_login');
        // return view('auth/Auth_register');
    }

    public function error_perm()
    {
        return view("auth/Auth_noPerm");
    }
}
