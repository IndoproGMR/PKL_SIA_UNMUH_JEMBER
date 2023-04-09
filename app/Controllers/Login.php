<?php

namespace App\Controllers;

use App\Controllers\BaseController;





class Login extends BaseController
{
    public function index()
    {
        return view("login");
    }

    public function debuglogin($jabatan, $nama)
    {
        echo "Jabatan: " . $jabatan;
        echo "</br>";
        echo "nama: " . $nama;
    }
}
