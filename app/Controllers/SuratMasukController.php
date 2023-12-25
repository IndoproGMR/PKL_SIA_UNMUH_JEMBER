<?php

namespace App\Controllers;

use App\Controllers\BaseController;
use App\Models\SuratMasukModel;

// !Update FlashMassage

class SuratMasukController extends BaseController
{
    protected $Filter_Jenis_Surat;

    function __construct()
    {
        helper('authvalid');

        $prefix = "Query_Filter_Jenis_Surat_Masuk";
        if (cekCacheData($prefix, '')) {
            $model = model('JenisSuratMasukModel');
            $Filter_Jenis_Surat = $this->Filter_Jenis_Surat = $model->seeall();
            setCacheData($prefix, $Filter_Jenis_Surat, 600, '');
        } else {
            $this->Filter_Jenis_Surat = getCachaData($prefix, '');
        }

        // $data['jenisFilter'] = $this->Filter_Jenis_Surat;
    }

    public function indexArchiveSurat()
    {
        PagePerm(['Dosen']);

        $dataGet      = ($filter = $this->request->getGet('filter')) ? $filter : 'all';
        // $TanggalSurat = ($filter = $this->request->getGet('TanggalSurat')) ? $filter : null;
        $dataGetTextF = ($filter = $this->request->getGet('TextF')) ? $filter : null;
        $dataGetlimit = ($filter = $this->request->getGet('limit')) ? $filter : 10;


        $dateStart = ($filter = $this->request->getGet('tglS')) ? $filter : null;
        $dateEnd = ($filter = $this->request->getGet('tglE')) ? $filter : null;

        $data['dateStart'] = $dateStart;
        $data['dateEnd'] = $dateEnd;
        $data['Datalimit'] = $dataGetlimit;




        // $data['TanggalSurat'] = $TanggalSurat;

        $data['dataGetTextF'] = $dataGetTextF;
        $data['jenisFilter'] = $this->Filter_Jenis_Surat;
        $data['filter'] = $dataGet;

        $modelsurat = model('SuratMasukModel');
        $data['surat'] = $modelsurat->seeallbyFilter(
            $dataGet,
            $dataGetTextF,
            $data['dateStart'],
            $data['dateEnd'],
            $data['Datalimit']
        );

        $data['suratNoJenis'] = $modelsurat->seeAllNoJenisSuratID();

        return view('suratMasuk/semua_surat', $data);
    }

    // ! Surat ArchiveSurat
    public function addArchiveSurat()
    {
        PagePerm(['Dosen']);

        $data['jenisFilter'] = $this->Filter_Jenis_Surat;

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

        // !Tambahkan Validasi text

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
        ];
        // d($dataSimpan);
        $model = model('SuratMasukModel');
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
        $model = Model('SuratMasukModel');
        $namaFile = $model->seebyid($postdata);

        // d($namaFile);

        $model = model('JenisSuratMasukModel');
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
        $data['jenisFilter'] = $this->Filter_Jenis_Surat;

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
        $model = Model('SuratMasukModel');
        $data = [
            'DiskirpsiSurat'       => $postdata['DiskirpsiSurat'],
            'NomerSurat'           => $postdata['NomerSurat'],
            'TanggalSurat'         => $postdata['TanggalSurat'],
            'DataSurat'            => $postdata['DataSurat'],
            'JenisSuratArchice_id' => $postdata['jenisFilter'],
        ];

        $prefix = "Query_indexArchiveSurat_";
        delCacheData($prefix);

        if (!$model->updateSuratMasuk($postdata['id'], $data)) {
            return FlashMassage('/input-archive-surat', [resMas('f')]);

            // return FlashException('Gagal Meng update Surat');
        }
        return FlashMassage('/semua-archive-surat', [resMas('s.save')], 'success');
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
        if (file_exists($filepathZ_archive)) {
            if (!moveFile($filepathZ_archive, $filepathTemp)) {
                return FlashMassage('/semua-archive-surat', [resMas('f')]);
                // return 'gagal memindahkan file ke temp';
            }

            if (!deleteFile($filepathWrite)) {
                return FlashMassage('/semua-archive-surat', [resMas('f')]);

                // return 'gagal menghapus file main folder';
            }
        }

        if (!$model->deleteSuratMasuk($postdata)) {
            return FlashMassage('/semua-archive-surat', [resMas('r')]);
            // return 'gagal menghapus surat';
        }

        $prefix = "Query_indexArchiveSurat_";
        delCacheData($prefix);

        return FlashMassage('/semua-archive-surat', [resMas('s')]);
    }

    // !Jenis Surat
    public function addJenisArchiveSurat()
    {
        PagePerm(['Dosen']);
        $model = model('JenisSuratMasukModel');
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

        // $postdata['TimeStamp'] = getUnixTimeStamp();
        $dataSimpan = [
            'name' => $postdata['Name'],
            'description' => $postdata['DiskripsiJenis']
            // 'TimeStamp' => $postdata['TimeStamp']
        ];

        $prefix = "Query_Filter_Jenis_Surat_Masuk";
        delCacheData($prefix, '');

        // d($dataSimpan);

        // return;
        $model = model('JenisSuratMasukModel');
        if (!$model->addJenisSurat($dataSimpan)) {
            return FlashMassage('/input-archive-surat', [resMas('f')]);

            // return FlashException('Tidak dapat Meminta Mengisi Jenis Surat');
        }
        return FlashMassage('/input-archive-surat', [resMas('S.save')]);

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
        return FlashMassage('/input-archive-surat', [resMas('s.save')]);

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
