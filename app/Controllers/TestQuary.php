<?php

namespace App\Controllers;

use App\Controllers\BaseController;

class TestQuary extends BaseController
{
    public function index()
    {
        return view('quary/test_quary');
    }

    public function caridata()
    {
        helper('datacall');
        $postdata = $this->request->getPost([
            'SearchData'
        ]);

        $data['pencarian'] = datacallorder();

        $needle   = '-order:';
        $hasil = explode(" ", $postdata['SearchData']);
        $lokasi = 0;
        if ($needle && str_contains($postdata['SearchData'], $needle)) {
            $lokasi = array_search($needle, $hasil);
            $lokasi = array_search_partial($hasil, $needle);
        }
        // echo "<br>";
        // echo $lokasi;


        d($lokasi);
        d($postdata);
        d($data);
        d($hasil);
    }
}
