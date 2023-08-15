<?php

namespace App\Controllers;

use App\Controllers\BaseController;
use App\Models\JenisSuratMasukModel;
use App\Models\SuratMasukModel;

class SuratMasukController extends BaseController
{
    public function indexArhiveSurat()
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

    public function addArhiveSurat()
    {
        PagePerm(['Dosen']);
        $model = model(JenisSuratMasukModel::class);
        $data['jenisFilter'] = $model->seeall();

        return view('suratMasuk/input_arhive', $data);
    }

    public function addArhiveSuratProses()
    {
        PagePerm(['Dosen'], 'error_perm', false, 1);

        $postdata = $this->request->getPost([
            'jenissuratid',
            'DiskirpsiSurat',
            'NomerSurat',
            'TanggalSurat',
            'DataSurat',
            'filepdf'
        ]);
        // d($postdata);

        $validationRule = Validasi_FilePDF();
        // !ganti php.ini untuk menambah upload limit

        if (!$this->validate($validationRule)) {
            $data = ['errors' => $this->validator->getErrors()];
            return FlashException('Tidak Dapat Menambahkan PDF');
        }

        $filepdf = $this->request->getFile('filepdf');

        if ($filepdf->isValid() && !$filepdf->hasMoved()) {
            $filepath = "ArhiveSurat/pdf";
            $extension = $filepdf->getExtension();
            $extension = empty($extension) ? '' : '.' . $extension;
            $filename = generateIdentifier() . $extension;

            // !menyimpan file ke dalam folder public
            try {
                $filepdf->move(WRITEPATH . $filepath, $filename);
            } catch (\Throwable $th) {
                return FlashException('Tidak Dapat Menyimpan PDF');
            }

            // !Copy file ke folder Arhive
            $fileFrom = WRITEPATH . $filepath . "/" . $filename;
            $fileTo = cekDir("../Z_Archive/" . $filepath) . "/" . $filename;

            if (!copyFile($fileFrom, $fileTo)) {
                return FlashException('Tidak Dapat Menyimpan PDF ke safeplace');
            }



            $filepath = $filepath . '/' . $filename;
            $postdata['filepdf'] = $filepath;
        }
        // d($postdata);

        $dataSimpan = [
            'DiskirpsiSurat'       => $postdata['DiskirpsiSurat'],
            'NomerSurat'           => $postdata['NomerSurat'],
            'TanggalSurat'         => $postdata['TanggalSurat'],
            'DataSurat'            => $postdata['DataSurat'],
            'NamaFile'             => $postdata['filepdf'],
            'JenisSuratArchice_id' => $postdata['jenissuratid'],
            'TimeStamp'            => getUnixTimeStamp()
        ];
        // d($dataSimpan);
        $model = model(SuratMasukModel::class);
        if (!$model->addSuratMasuk($dataSimpan)) {
            return FlashException('Tidak dapat menginputkan Surat kedatabase');
        }
        return FlashSuccess('/input-arhive-surat', 'Berhasil Menyimpan Surat');
    }

    public function addJenisArhiveSurat()
    {
        PagePerm(['Dosen']);
        $model = model(JenisSuratMasukModel::class);
        $data['jenisFilter'] = $model->seeall();
        // d($data);


        return view('suratMasuk/input_jenis_arhive', $data);
    }

    public function addJenisArhiveSuratProses()
    {
        PagePerm(['Dosen'], 'error_perm', false, 1);
        // echo 'proses';
        $postdata = $this->request->getPost([
            'Name',
            'DiskripsiJenis'
        ]);
        $postdata['TimeStamp'] = getUnixTimeStamp();
        // d($postdata);
        $dataSimpan = [
            'name' => $postdata['Name'],
            'description' => $postdata['DiskripsiJenis'],
            'TimeStamp' => $postdata['TimeStamp']
        ];
        $model = model(JenisSuratMasukModel::class);
        if (!$model->addJenisSurat($dataSimpan)) {
            return FlashException('Tidak dapat Meminta Mengisi Jenis Surat');
        }
        return FlashSuccess('/input-jenis-arhive-surat', 'Berbahasil Menyimpan Jenis Surat');
    }

    public function TestInfo()
    {
        // return phpinfo();
    }
}
