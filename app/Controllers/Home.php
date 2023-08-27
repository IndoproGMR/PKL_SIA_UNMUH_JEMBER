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
        d(FlashMassage('', '', '', 'get'));
        // d(FlashMassage('', '', '', 'get')['massage']);
        // d(FlashMassage('', '', '', 'get')['type']);
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
