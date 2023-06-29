<?php

namespace App\Controllers;

use App\Controllers\BaseController;
use App\Libraries\enkripsi_library;
use App\Models\Suratmasuk;
use App\Models\TandaTangan;

class StatuSurat extends BaseController
{
    // !untuk Mahasiswa
    public function statusSurat()
    {
        PagePerm([''], '/login', true);
        $model = model(Suratmasuk::class);
        $model2 = model(TandaTangan::class);
        $data['datasurat'] = $model->cekNoSurat(userInfo()['id']);

        foreach ($data['datasurat'] as $key => $value) {
            $data['surat'][$key] = $value['NoSurat'];
            $data['datasurat'][$key]['status'] = $model2->cekStatusSurat($data['surat'][$key]);
        }

        // d($data);

        return view('suratmasuk/status_surat', $data);
    }

    public function riwatSurat()
    {
    }


    // !untuk Dosen
    public function statusTTD()
    {
        PagePerm(['Dosen']);
        $model = model(TandaTangan::class);
        $data['datasurat'] = $model->cekStatusSuratTTD(userInfo());

        foreach ($data['datasurat'] as $key => $value) {
            $data['surat'][$key] = $value['NoSurat'];
            $data['datasurat'][$key]['status'] = $model->cekStatusSurat($data['surat'][$key]);
        }

        return view('suratmasuk/status_ttd', $data);
    }

    public function prosesTTD()
    {
        $postdata = $this->request->getPost([
            'id',
        ]);



        $model = model(TandaTangan::class);
        $data['TTD'] = $model->cekStatusById($postdata['id']);


        if (!$data['TTD']['Status'] == 0) {
            return "surat Sudah di TTd ngi";
        }

        $enkripsi = new enkripsi_library;

        $data['update']['Status'] = 1;
        $data['update']['hash'] = $enkripsi->enkripsiTTD($data['TTD']['NoSurat'], $data['TTD']['mshw_id']);
        $data['update']['TimeStamp'] = time();
        $data['update']['pendattg_id'] = userInfo()['id'];


        if (!$model->updateTTD($postdata['id'], $data['update'])) {
            return "TTD error";
        }
        return redirect()->to('/StatusTTD');
    }

    public function riwayatTTD()
    {
    }

    public function riwayatSurat()
    {
    }
}
