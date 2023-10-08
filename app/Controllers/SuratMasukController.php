<?php

namespace App\Controllers;

use App\Controllers\BaseController;
use App\Models\JenisSuratMasukModel;
use App\Models\SuratMasukModel;

// !Update FlashMassage

class SuratMasukController extends BaseController
{
    public function indexArchiveSurat()
    {
        PagePerm(['Dosen']);
        $getget = ($filter = $this->request->getGet('filter')) ? $filter : 'all';

        $namacache = "Query_indexArchiveSurat_$getget";
        if (cekCacheData($namacache)) {

            $model = model('JenisSuratMasukModel');
            $data['jenisFilter'] = $model->seeall();

            $modelsurat = model('SuratMasukModel');
            $data['surat'] = $modelsurat->seeallbyJenis($getget);

            setCacheData($namacache, $data);
        } else {
            $data['jenisFilter'] = getCachaData($namacache)['jenisFilter'];
            $data['surat'] = getCachaData($namacache)['surat'];
        }

        $data['filter'] = $getget;

        return view('suratMasuk/semua_surat', $data);
    }

    // ! Surat ArchiveSurat
    public function addArchiveSurat()
    {
        PagePerm(['Dosen']);

        $namacache = "Query_addArchiveSurat_";
        if (cekCacheData($namacache)) {

            $model = model('JenisSuratMasukModel');
            $data['jenisFilter'] = $model->seeall();

            setCacheData($namacache, $data);
        } else {
            $data['jenisFilter'] = getCachaData($namacache)['jenisFilter'];
        }

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
            return FlashMassage('/input-archive-surat', [resMas('f')]);
            // return FlashException('Tidak dapat menginputkan Surat kedatabase');
        }

        $prefix = "Query_indexArchiveSurat_";
        delCacheData($prefix);

        return FlashMassage('/input-archive-surat', [resMas('s.save.surat')]);
    }

    public function updateArchiveSurat()
    {
        PagePerm(['Dosen']);

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

        return view('suratMasuk/edit_surat', $data);
    }

    public function updateArchiveSuratProses()
    {
        PagePerm(['Dosen'], 'error_perm', false, 1);

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

        $prefix = "Query_indexArchiveSurat_";
        delCacheData($prefix);

        if (!$model->updateSuratMasuk($postdata['id'], $data)) {
            return FlashMassage('/input-archive-surat', [resMas('f')]);

            // return FlashException('Gagal Meng update Surat');
        }
        return FlashMassage('/input-archive-surat', [resMas('f')]);
    }

    public function deleteArchiveSuratProses()
    {
        PagePerm(['Dosen'], 'error_perm', false, 1);

        // echo 'delete surat';
        $postdata = $this->request->getPost('id');
        // d($postdata);
        $model = model('SuratMasukModel');

        $dataSurat = $model->seebyid($postdata);

        $filepathWrite = WRITEPATH . $dataSurat['NamaFile'];
        $filepathZ_archive = "../Z_Archive/" . $dataSurat['NamaFile'];
        $filepathTemp = WRITEPATH . "/temp/" . $dataSurat['NamaFile'];
        cekDir(WRITEPATH . '/temp/ArhiveSurat/pdf');
        if (!moveFile($filepathZ_archive, $filepathTemp)) {
            return FlashMassage('/input-archive-surat', [resMas('f')]);

            // return 'gagal memindahkan file ke temp';
        }

        if (!deleteFile($filepathWrite)) {
            return FlashMassage('/input-archive-surat', [resMas('f')]);

            // return 'gagal menghapus file main folder';
        }

        if (!$model->deleteSuratMasuk($postdata)) {
            return FlashMassage('/input-archive-surat', [resMas('f')]);
            // return 'gagal menghapus surat';
        }

        $prefix = "Query_indexArchiveSurat_";
        delCacheData($prefix);

        return FlashMassage('/input-archive-surat', [resMas('f')]);
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
            return FlashMassage('/input-archive-surat', [resMas('f')]);

            // return FlashException('Tidak dapat Meminta Mengisi Jenis Surat');
        }
        return FlashMassage('/input-archive-surat', [resMas('f')]);

        // return FlashSuccess('/input-jenis-archive-surat', 'Berbahasil Menyimpan Jenis Surat');
    }

    public function updateJenisArchiveSurat()
    {
        PagePerm(['Dosen']);

        $postdata = $this->request->getPost('id');

        $model = model('JenisSuratMasukModel');
        $data['surat'] = $model->seebyid($postdata);
        $data['count'] = $model->countByid($postdata);
        // d($postdata);
        // d($data);
        return view('suratMasuk/edit_jenis_arhive', $data);
    }

    public function updateJenisArchiveSuratProses()
    {
        PagePerm(['Dosen'], 'error_perm', false, 1);

        $postdata = $this->request->getPost([
            'id',
            'Name',
            'DiskripsiJenis'
        ]);
        // d($postdata);
        $data = [
            'name'        => $postdata['Name'],
            'description' => $postdata['DiskripsiJenis'],
        ];
        $model = model('JenisSuratMasukModel');

        if (!$model->updateJenisSurat($postdata['id'], $data)) {
            return FlashMassage('/input-archive-surat', [resMas('f')]);

            // return FlashException('Tidak dapat Meminta Mengisi Jenis Surat');
        }
        return FlashMassage('/input-archive-surat', [resMas('f')]);

        // return FlashSuccess('/input-jenis-archive-surat', 'Berbahasil Menyimpan Jenis Surat');
    }

    public function deleteJenisArchiveSuratProses()
    {
        PagePerm(['Dosen'], 'error_perm', false, 1);

        $postdata = $this->request->getPost('id');
        // d($postdata);
        $model = model('JenisSuratMasukModel');
        $model2 = model('SuratMasukModel');



        if (!$model2->setdeletejenisSuratMasuk($postdata)) {
            return FlashMassage('/input-archive-surat', [resMas('f')]);

            // return FlashException('Tidak dapat delete Surat ke 0');
        }

        if (!$model->setdeleteJenisSurat($postdata)) {
            return FlashMassage('/input-archive-surat', [resMas('f')]);

            // return FlashException('Tidak dapat Meminta Mengisi Jenis Surat');
        }
        return FlashMassage('/input-jenis-archive-surat', [resMas('s.save')]);

        // return FlashSuccess('/input-jenis-archive-surat', 'Berbahasil Menyimpan Jenis Surat');
    }
}
