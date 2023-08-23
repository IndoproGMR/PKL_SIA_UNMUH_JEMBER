<?php

namespace App\Controllers;

use App\Models\AuthUserGroup;
use App\Models\TandaTangan;
use Faker\Extension\Helper;

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

    public function TestInfo()
    {
        // $text = 'TTD.valid.t.n.exist.db.!2';
        // $data = 'Tanda Tangan Tidak ada Didalam Database!!!';

        $text = 'TTD.n.exist.db';
        d(resMas($text));
        d($text);



        // Helper('datacall');




        // d(resMas('F.u.save.Archive.k.??'));
        // d('F.u.save.Archive.k.??');

        // d(resMas('F.u.save.Archive.k.n.exist.db.!'));
        // d('F.u.save.Archive.k.n.exist.db');

        // d(resMas('edit.surat.?'));
        // d('edit.surat.?');

        // d(resMas('ttd.valid.t.n.exist.db.!2'));
        // d('ttd.valid.t.n.exist.db.!2');

        // d(resMas('conn.e.db'));
        // d('conn.e.db');
        // $data = 'Tanda Tangan Valid tapi tidak ada di dalam Database!!!';
        // return phpinfo();
    }
}
