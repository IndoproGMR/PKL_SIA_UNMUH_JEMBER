<?php

namespace App\Controllers;

use App\Controllers\BaseController;
use App\Models\Quary;

class TestQuary extends BaseController
{
    public function index()
    {
        $model = model(Quary::class);
        d($model->test2db());
        return view('quary/test_quary');
    }

    public function caridata()
    {
        $model = model(Quary::class);
        helper('datacall');
        $postdata = $this->request->getPost([
            'SearchData'
        ]);

        $data['pencarian'] = datacallorder(2);

        $needle   = '-order:';
        $hasil = explode(" ", $postdata['SearchData']);
        $lokasi = 0;
        $orderdata = "";
        $hasOption = false;

        if ($needle && str_contains($postdata['SearchData'], $needle)) {
            $lokasi = array_search($needle, $hasil);
            $lokasi = array_search_partial($hasil, $needle);
            $orderdata = quarytranslate($hasil[$lokasi]);
            $hasOption = true;
        }

        // d(str_contains($hasil[0], $needle));
        // d($hasil[0]);

        if ($hasOption) {
            if (str_contains($hasil[0], $needle)) {
                $data['isiquary'] = $model->orderquary($orderdata['order'], $orderdata['options']);
            } else {
                $data['isiquary'] = $model->cariquary($hasil[0], $orderdata['order'], $orderdata['options']);
            }
        } else {
            $data['isiquary'] = $model->cariquary($hasil[0]);
        }

        $data['jumlah'] = $model->countdb();



        // .com -order:name_ASC-id>100

        d($lokasi);
        d($orderdata);
        d($hasil);
        d($postdata);
        d($data);
    }
}
