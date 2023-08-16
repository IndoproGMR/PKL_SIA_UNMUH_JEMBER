<?php

namespace App\Controllers;

use App\Controllers\BaseController;
use App\Models\JenisSuratMasukModel;
use App\Models\SuratMasukModel;

class SuratMasukController extends BaseController
{
    public function indexArchiveSurat()
    {
        PagePerm(['Dosen']);
        $getget = ($filter = $this->request->getGet('filter')) ? $filter : 'all';
        $model = model(JenisSuratMasukModel::class);
        $data['jenisFilter'] = $model->seeall();
        $modelsurat = model(SuratMasukModel::class);
        $data['surat'] = $modelsurat->seeallbyJenis($getget);
        $data['filter'] = $getget;


        // d($data);
        // d($getget);

        return view('suratMasuk/semua_surat', $data);
    }

    // ! Surat ArchiveSurat
    public function addArchiveSurat()
    {
        PagePerm(['Dosen']);
        $model = model(JenisSuratMasukModel::class);
        $data['jenisFilter'] = $model->seeall();

        return view('suratMasuk/input_arhive', $data);
    }

    public function addArchiveSuratProses()
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

    public function updateArchiveSurat()
    {
        $postdata = $this->request->getPost('id');
        $model = Model(SuratMasukModel::class);
        $namaFile = $model->seebyid($postdata);
        $model = model(JenisSuratMasukModel::class);
        $data = [
            'id'                   => $postdata,
            'DiskirpsiSurat'       => $namaFile['DiskirpsiSurat'],
            'NomerSurat'           => $namaFile['NomerSurat'],
            'TanggalSurat'         => $namaFile['TanggalSurat'],
            'DataSurat'            => $namaFile['DataSurat'],
            'name'                 => $namaFile['name'],
            'JenisSuratArchice_id' => $namaFile['JenisSuratArchice_id'],
            'TimeStamp'            => $namaFile['TimeStamp'],
        ];
        $data['jenisFilter'] = $model->seeall();

        d($namaFile);
        d($postdata);
        d($data);
        return view('suratMasuk/edit_surat', $data);
    }

    public function updateArchiveSuratProses()
    {
        $postdata = $this->request->getPost(
            [
                'id',
                'DiskirpsiSurat',
                'NomerSurat',
                'TanggalSurat',
                'DataSurat',
                'jenisFilter',
            ]
        );
        $model = Model(SuratMasukModel::class);
        $data = [
            'DiskirpsiSurat'       => $postdata['DiskirpsiSurat'],
            'NomerSurat'           => $postdata['NomerSurat'],
            'TanggalSurat'         => $postdata['TanggalSurat'],
            'DataSurat'            => $postdata['DataSurat'],
            'JenisSuratArchice_id' => $postdata['jenisFilter'],
            'TimeStampUpdate'      => getUnixTimeStamp(),
        ];

        d($postdata);
        d($data);
        if (!$model->updateSuratMasuk($postdata['id'], $data)) {
            return FlashException('Gagal Meng update Surat');
        }
        return FlashSuccess('semua-archive-surat', 'berhasil Meng Update Surat');
    }

    // !Jenis Surat
    public function addJenisArchiveSurat()
    {
        PagePerm(['Dosen']);
        $model = model(JenisSuratMasukModel::class);
        $data['jenisFilter'] = $model->seeall();
        // d($data);


        return view('suratMasuk/input_jenis_arhive', $data);
    }

    public function addJenisArchiveSuratProses()
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
}
