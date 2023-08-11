<?php

namespace App\Controllers;

use App\Controllers\BaseController;
use App\Models\JenisSuratMasukModel;
use App\Models\SuratMasukModel;

class SuratMasukController extends BaseController
{
    public function indexArhiceSurat()
    {
        PagePerm(['Dosen']);
        $getget = ($filter = $this->request->getGet('filter')) ? $filter : 'all';
        $model = model(JenisSuratMasukModel::class);
        $modelsurat = model(SuratMasukModel::class);
        $data['jenisFilter'] = $model->seeall();
        $data['surat'] = $modelsurat->seeallbyJenis($getget);


        // d($data);
        // d($getget);

        return view('suratMasuk/semua_surat', $data);
    }
}
