<?php

namespace App\Controllers;

use App\Models\AuthUserGroup;
use App\Models\TandaTangan;

class Home extends BaseController
{
    public function index()
    {
        PagePerm([''], '/login', true);

        // return view('auth/Auth_login');
        return view('home/index');
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
}
