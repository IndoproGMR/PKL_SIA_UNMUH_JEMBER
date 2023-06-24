<?php

namespace App\Controllers;

use App\Controllers\BaseController;
use App\Models\Suratmasuk;
use App\Models\TandaTangan;

class StatuSurat extends BaseController
{
    public function index()
    {
        PagePerm([''], '/login', true);
        $model = model(Suratmasuk::class);
        $model2 = model(TandaTangan::class);
        $data['datasurat'] = $model->cekNoSurat(userInfo()['id']);

        foreach ($data['datasurat'] as $key => $value) {
            $data['surat'][$key] = $value['NoSurat'];
            $data['datasurat'][$key]['status'] = $model2->cekStatusSurat($data['surat'][$key]);
        }


        return view('suratmasuk/status_surat', $data);
    }
}
