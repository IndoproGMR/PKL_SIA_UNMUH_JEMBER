<?php

namespace App\Controllers;

use App\Controllers\BaseController;
use App\Libraries\enkripsi_library;

class SuratKeluarController extends BaseController
{
    protected $Filter_Jenis_Surat;

    function __construct()
    {
        helper('authvalid');

        $prefix = "Query_Filter_Jenis_Surat_Keluar";
        if (cekCacheData($prefix, '')) {
            $model = model('MasterSuratModel');
            $Filter_Jenis_Surat = $this->Filter_Jenis_Surat = $model->seeall();
            setCacheData($prefix, $Filter_Jenis_Surat, 600, '');
        } else {
            $this->Filter_Jenis_Surat = getCachaData($prefix, '');
        }



        // $data['jenisFilter'] = $this->Filter_Jenis_Surat;

    }

    // !START Untuk Mahasiswa
    // untuk melihat semua surat yang dimanta apakah sudah di ttd ngi
    public function indexStatusSurat()
    {
        PagePerm(['Mahasiswa', 'Calon Mahasiswa']);

        $namacache = "Query_indexStatusSurat_";
        if (cekCacheData($namacache)) {

            $model = model('SuratKeluraModel');
            $model2 = model('TandaTangan');
            $data['datasurat'] = $model->cekNoSurat(userInfo()['id'], true);

            // cek status setiap surat
            foreach ($data['datasurat'] as $key => $value) {
                $data['surat'][$key] = $value['SuratIdentifier'];
                $data['datasurat'][$key]['status'] = $model2->cekStatusSurat($data['surat'][$key]);
            }

            // bila status yang belum sudah 0 maka hapus dari array
            foreach ($data['datasurat'] as $key => $value) {
                if ($value['status']['belum'] == '0') {
                    unset($data['datasurat'][$key]);
                }
            }

            setCacheData($namacache, $data, 120);
        } else {
            $data = getCachaData($namacache);
        }


        return view('suratkeluar/mahasiswa/semua_Status_TTD', $data);
    }

    // page minta surat 2 fungsi ada dropdown ada konten box untuk mengisi data
    public function indexMintaSurat($idsurat = null)
    {
        PagePerm(['Mahasiswa', 'Calon Mahasiswa']);

        if (userInfo()['BL'] !== 'N') {
            $model = model('ServerConfig');
            $data['detailBL'] = $model->cekBLDetail(userInfo()['id']);
            return view('suratkeluar/mahasiswa/Dalam_Blacklist', $data);
        }

        $data['jenissurat'] = $this->Filter_Jenis_Surat;

        $data['minta'] = 0;

        // cek apakah id surat null?
        if (!is_null($idsurat)) {
            // cek data jenis surat
            $prefix = "Query_idsurat_" . $idsurat;
            if (cekCacheData($prefix, '')) {

                $data['minta'] = 1;

                $model = model('MasterSuratModel');
                $data['datasurat'] = $model->seeMasterSuratbyID($idsurat);

                // cek apakah id yang diminta ada di db ?
                if ($data['datasurat']['error'] == 'y') {
                    return FlashMassage('/Surat/Minta-TandaTangan', [resMas('id.master.surat.n.exist')], 'unknown');
                }

                $data['dataform'] = json_decode($data['datasurat']['form'], true);

                setCacheData($prefix, $data, 600, '');
            } else {
                $data = getCachaData($prefix, '');
            }
        }

        return view('suratkeluar/mahasiswa/Proses_Minta-TTD', $data);
    }

    // proses data untuk meminta
    public function addMintaSuratProses()
    {
        PagePerm(['Mahasiswa', 'Calon Mahasiswa'], 'error_perm', false, 1);

        if (userInfo()['BL'] !== 'N') {
            return FlashMassage('Surat/Minta-TandaTangan', [resMas('F')], 'warning');
        }

        helper(['text']);

        $model3 = model('MasterSuratModel');

        $postdata = $this->request->getPost();
        $idsurat = $postdata['id'];

        $masterSurat = $model3->seeMasterSuratbyID($idsurat);
        $dataform = json_decode($masterSurat['form'], 'array');

        // !Validasi dan save gambar Start
        if (isset($dataform['tambahan'])) {
            if (in_array('foto', $dataform['tambahan'])) {
                $validationRule = Validasi_Foto();

                if (!$this->validate($validationRule)) {
                    $dataerror = $this->validator->getErrors();
                    return FlashMassage('Surat/Minta-TandaTangan/' . $idsurat, $dataerror, 'fail');
                    // return FlashException('Tidak Dapat Menambahkan Foto');
                }

                $img = $this->request->getFile('foto');

                if ($img->isValid() && !$img->hasMoved()) {
                    $filepath = "uploads/SuratKeluar/" . userInfo()['id'];
                    $extension = $img->getExtension();
                    $extension = empty($extension) ? '' : '.' . $extension;
                    $filename = generateIdentifier(16, 'time') . $extension;

                    // !menyimpan foto ke dalam folder public
                    try {
                        $img->move($filepath, $filename);
                    } catch (\Throwable $th) {
                        return FlashMassage('Surat/Minta-TandaTangan/' . $idsurat, [resMas('f.u.save.fl.db')], 'fail');
                        // return FlashException('Tidak Dapat Menyimpan Foto');
                    }

                    // !Copy file ke folder Arhive
                    $fileFrom = $filepath . "/" . $filename;
                    $fileTo = cekDir("../Z_Archive/" . $filepath) . "/" . $filename;

                    if (!copyFile($fileFrom, $fileTo)) {
                        return FlashMassage('Surat/Minta-TandaTangan/' . $idsurat, [resMas('f.u.save.fl.server')], 'fail');
                        // return FlashException('Tidak Dapat Menyimpan Foto ke safeplace');
                    }

                    $filepath = $filepath . '/' . $filename;
                }
                $postdata['foto'] = $filepath;
            }
        }
        // !Validasi dan save gambar End


        // !Validasi input Start
        // $dataerror = null;
        // foreach ($postdata as $key => $value) {
        //     $validationRule = Validasi_Input($key);
        //     // !ganti php.ini untuk menambah upload limit

        //     if (!$this->validate($validationRule)) {
        //         $dataerror = $this->validator->getErrors();
        //     }
        // }

        // if (!$dataerror == null) {
        //     return FlashMassage('/minta-surat/' . $idsurat, $dataerror, 'fail');
        // }
        // !Validasi input End

        unset($postdata['id']);
        $dataformarray = json_decode(json_encode($postdata), true);


        // !untuk menyimpan SuratKeluar
        $data['SuratIdentifier'] = generateIdentifier();
        $data['DataTambahan']    = base64_encode(json_encode($dataformarray));
        $data['MasterSurat_id']  = $idsurat;
        $data['mshw_id'] = userInfo()['id'];

        // !untuk menyimpan TTD
        $TTDdata['TTD'] = removeGroups(json_decode($masterSurat['form'], true)['TTD']);
        $TTDdata['SuratIdentifier'] = $data['SuratIdentifier'];
        $ttdArray = transformData($TTDdata);


        /**
         * unutk TTDdata['status','hash','IdentifierSurat','Timestamp']
         * berada di fungsi transformData(data);
         */
        $model  = model('SuratKeluraModel');
        // set ke dalam database
        if (!$model->addSuratKeluar($data)) {
            return FlashMassage('Surat/Minta-TandaTangan', [resMas('f.u.minta.surat')]);
        }

        $model2 = model('TandaTangan');
        if (!$model2->addTTD($ttdArray)) {
            return FlashMassage('Surat/Minta-TandaTangan', [resMas('f.u.minta.ttd')]);
        }

        $prefix = "Query_indexStatusSurat_";
        delCacheData($prefix);

        return FlashMassage('Surat/Status-TandaTangan', [resMas('s.u.minta.surat')], 'success');
    }

    // melihat riwayat surat yang sudah full ttd
    public function indexRiwayatSurat()
    {
        PagePerm(['Mahasiswa', 'Calon Mahasiswa']);


        $dataGet = ($filter = $this->request->getGet('filter')) ? $filter : 'all';
        $limitQuary = ($filter = $this->request->getGet('limit')) ? $filter : 10;


        $dateStart = ($filter = $this->request->getGet('tglS')) ? $filter : null;
        $dateEnd = ($filter = $this->request->getGet('tglE')) ? $filter : null;

        $data['dateStart'] = $dateStart;
        $data['dateEnd'] = $dateEnd;
        $data['limit'] = $limitQuary < 0 ? 1 : $limitQuary;
        $data['filter'] = $dataGet;


        $namacache = "Query_indexRiwayatSurat_" . hash256($data);
        if (cekCacheData($namacache)) {
            $model = model('SuratKeluraModel');
            $model2 = model('TandaTangan');
            $data['datasurat'] = $model->cekNoSurat(userInfo()['id'], false, $data['filter'], $data['dateStart'], $data['dateEnd'], $data['limit']);

            foreach ($data['datasurat'] as $key => $value) {
                $data['surat'][$key] = $value['SuratIdentifier'];
                $data['datasurat'][$key]['status'] = $model2->cekStatusSurat($data['surat'][$key]);
            }

            foreach ($data['datasurat'] as $key => $value) {
                if ($value['status']['belum'] !== '0') {
                    unset($data['datasurat'][$key]);
                }
            }

            setCacheData($namacache, $data, 120);
        } else {
            $data = getCachaData($namacache);
        }

        $data['jenisFilter'] = $this->Filter_Jenis_Surat;
        // d($data);
        // return;
        return view('suratkeluar/mahasiswa/Semua_Riwayat-TTD', $data);
    }
    // !END Untuk Mahasiswa


    // !START untuk pengajaran
    // untuk melihat macam2 jenis surat jenis surat
    public function indexJenisSurat()
    {
        PagePerm(['Dosen']);

        $namacache = "Query_indexJenisSurat";
        if (cekCacheData($namacache, '')) {

            $jenissurat = model('MasterSuratModel');
            $data['jenissurat'] = $jenissurat->seeall(true);

            setCacheData($namacache, $data, 600, '');
        } else {
            $data = getCachaData($namacache, '');
        }

        return view('suratkeluar/pengajaran/Semua_Master-surat', $data);
    }

    // untuk mengisi jenis Master surat
    public function addJenisSurat()
    {
        PagePerm(['Dosen']);

        $jenissurat = model('MasterSuratModel');
        $data['level'] = $jenissurat->seeGrouplvl();
        $data['ttd'] = $jenissurat->seeNamaPettd();
        return view('suratkeluar/pengajaran/Input_Master-Surat', $data);
    }

    // untuk menambah jenis Master surat ke db
    public function addJenisSuratProses()
    {
        PagePerm(['Dosen'], 'error_perm', false, 1);

        $postdatasurat = $this->request->getPost(
            [
                'inputisi',
                'jenisSurat',
                'diskripsi'
            ]
        );

        $postdataform = $this->request->getPost(
            [
                'input',
                'tambahan',
                'TTD'
            ]
        );

        // !Validasi input Start
        $postdatarequired = $this->request->getPost(
            [
                'inputisi',
                'jenisSurat',
                'diskripsi',
                'TTD'
            ]
        );

        $dataerror = null;
        foreach ($postdatarequired as $key => $value) {
            $validationRule = Validasi_Input($key);
            // !ganti php.ini untuk menambah upload limit

            if (!$this->validate($validationRule)) {
                $dataerror = $this->validator->getErrors();
            }
        }

        if (!$dataerror == null) {
            return FlashMassage('/input/master-surat', $dataerror, 'warning');
        }
        // !Validasi input End

        foreach ($postdataform as $key => $value) {
            if ($value == null) {
                unset($postdataform[$key]);
            }
        }

        $data['json_data'] = json_encode($postdataform);

        $model = model('MasterSuratModel');

        if (!$model->addMasterSurat($postdatasurat['jenisSurat'], $postdatasurat['diskripsi'], $postdatasurat['inputisi'], $data['json_data'])) {
            // return FlashMassage('/input/master-surat', [resMas('f.u.save.master.surat.db')], 'fail');
            // return FlashException('Tidak dapat Menambahkan Surat ke dalam DataBase');
        }


        $prefix = "Query_indexJenisSurat";
        delCacheData($prefix, '');

        return FlashMassage('/Staff/Master-Surat', [resMas('s.save.master.surat.db')], 'success');
    }

    // untuk melihat detail jenis surat
    public function editJenisSurat($idsurat)
    {
        PagePerm(['Dosen']);
        $model = model('MasterSuratModel');
        $data['datasurat'] = $model->seeMasterSuratbyID($idsurat, 1);

        // cek apakah id yang diminta ada di db ?
        if ($data['datasurat']['error'] == 'y') {
            return FlashMassage('/Surat/Master-Surat', [resMas('id.master.surat.n.exist')], 'unknown');
        }

        return view('suratkeluar/pengajaran/Edit_Master_Surat', $data);
    }

    // untuk meng update jenis surat ke db
    public function editJenisSuratProses()
    {
        PagePerm(['Dosen'], 'error_perm', false, 1);
        $postdata = $this->request->getPost(
            [
                'id',
                'inputisi',
                'jenisSurat',
                'diskripsi'
            ]
        );

        // !Validasi input Start
        $dataerror = null;
        foreach ($postdata as $key => $value) {
            $validationRule = Validasi_Input($key);

            if (!$this->validate($validationRule)) {
                $dataerror = $this->validator->getErrors();
            }
        }

        if (!$dataerror == null) {
            return FlashMassage('/Staff/Master-Surat', $dataerror, 'warning');
        }
        // !Validasi input End

        $model = model('MasterSuratModel');
        if (!$model->updateMasterSurat($postdata['id'], $postdata['jenisSurat'], $postdata['diskripsi'], $postdata['inputisi'])) {
            return FlashMassage('/Staff/Master-Surat', [resMas('f.update.master.surat.db')], 'success');
        }

        $prefix = "Query_indexJenisSurat";
        delCacheData($prefix, '');


        $prefix = "Query_idsurat_" . $postdata['id'];
        delCacheData($prefix, '');

        return FlashMassage('/Staff/Master-Surat', [resMas('s.update.master.surat')], 'success');
    }

    // untuk menToggle visiblity master surat kepada mahasiswa
    public function updateJenisSuratToggleProses()
    {
        PagePerm(['Dosen'], 'error_perm', false, 1);
        $postdata = $this->request->getPost(['id']);
        $model = model('MasterSuratModel');

        if (!$model->toggleshow($postdata['id'])) {
            return FlashMassage('/semua_master-surat', [resMas('f.update.surat')], 'fail');
        }

        $prefix1 = 'Data_MasterSurat_' . $postdata['id'];
        delCacheData($prefix1, '');

        $prefix2 = "Query_indexJenisSurat";
        delCacheData($prefix2, '');

        $prefix3 = "Query_Filter_Jenis_Surat_Keluar";
        delCacheData($prefix3, '');

        return FlashMassage('/Staff/Master-Surat', [resMas('s.update.master.surat')], 'success');
    }



    public function indexTanpaNoSurat()
    {
        PagePerm(['Dosen']);


        $dataGet = ($filter = $this->request->getGet('filter')) ? $filter : 'all';
        $dataGetTextF = ($filter = $this->request->getGet('TextF')) ? $filter : null;

        $dateStart = ($filter = $this->request->getGet('tglS')) ? $filter : null;
        $dateEnd = ($filter = $this->request->getGet('tglE')) ? $filter : null;

        $data['dateStart'] = $dateStart;
        $data['dateEnd'] = $dateEnd;


        $model = model('SuratKeluraModel');
        $data['datasurat'] = $model->seeAllnoNoSuratWithJenis(
            $dataGet,
            $dataGetTextF,
            $data['dateStart'],
            $data['dateEnd']
        );

        $data['jenisFilter'] = $this->Filter_Jenis_Surat;

        $data['filter'] = $dataGet;
        $data['dataGetTextF'] = $dataGetTextF;


        return view('suratkeluar/pengajaran/Semua_Surat-Tanpa-Nomer', $data);
    }

    public function updateTanpaNoSurat()
    {
        PagePerm(['Dosen'], 'error_perm', false, 1);

        $postdata = $this->request->getPost('id');
        $model = model('SuratKeluraModel');
        $data = $model->cekSuratByNo($postdata);
        $data['id'] = $postdata;

        // d($data);

        return view('suratkeluar/pengajaran/Edit_Surat-Tanpa-Nomer', $data);
    }

    public function updateTanpaNoSuratProses()
    {
        PagePerm(['Dosen'], 'error_perm', false, 1);

        $postdata = $this->request->getPost(['id', 'NoSurat']);
        $model = model('SuratKeluraModel');

        // !Validasi input Start
        $dataerror = null;
        foreach ($postdata as $key => $value) {
            $validationRule = Validasi_Input($key);

            if (!$this->validate($validationRule)) {
                $dataerror = $this->validator->getErrors();
            }
        }

        if (!$dataerror == null) {
            return FlashMassage('Staff/Permintaan_TTD-Surat_Tanpa_NoSurat', $dataerror, 'warning');
        }
        // !Validasi input End


        $data = [
            'NoSurat' => $postdata['NoSurat']
        ];
        if (!$model->updateNoSurat($postdata['id'], $data)) {
            return FlashMassage('Staff/Permintaan_TTD-Surat_Tanpa_NoSurat', [resMas('f.save.surat')], 'fail');
        }

        return FlashMassage('Staff/Permintaan_TTD-Surat_Tanpa_NoSurat', [resMas('s.save.surat')], 'success');
    }

    public function deleteTanpaNoSuratProses()
    {
        PagePerm(['Dosen'], 'error_perm', false, 1);

        $postdata = $this->request->getPost('id');
        $model = model('SuratKeluraModel');
        if (!$model->deleteSurat($postdata)) {
            return FlashMassage('Staff/Permintaan_TTD-Surat_Tanpa_NoSurat', [resMas('f.update.surat')], 'fail');
            // return FlashException('gagal menghapus Surat');
        }

        return FlashMassage('Staff/Permintaan_TTD-Surat_Tanpa_NoSurat', [resMas('S.delete.surat')], 'success');
        // return FlashSuccess('semua-surat-tanpa_NoSurat', 'berhasil menghapus Surat');
    }

    public function indexReport()
    {
        PagePerm(['Dosen']);
        $dataGetTextF = ($filter = $this->request->getGet('TextF')) ? $filter : null;
        $limitQuary = ($filter = $this->request->getGet('limit')) ? $filter : 10;


        $data['limit'] = $limitQuary < 0 ? 1 : $limitQuary;
        $data['dataGetTextF'] = $dataGetTextF;


        $model = model('SuratKeluraModel');
        $model2 = model('AuthUserGroup');


        $dataSurat = $model->seeAllReport($dataGetTextF, $data['limit']);
        $data['Report'] = [];

        foreach ($dataSurat as $key => $value) {
            $data['Report'][$key]['SuratIdentifier']  = $value['SuratIdentifier'];
            $data['Report'][$key]['mahasiswa']        = $model2->cekmahasiswainfo($value['mshw_id'])['NamaUser'];
            $data['Report'][$key]['Report_diskripsi'] = json_decode(base64_decode($value['Report_diskripsi']), true);
            $data['Report'][$key]['updated_at']       = $value['updated_at'];
            $data['Report'][$key]['NoSurat']          = $value['NoSurat'];
            $data['Report'][$key]['JenisSurat']       = $value['JenisSurat'];
        }


        // d($data);

        return view('suratkeluar/pengajaran/semua_Report-Surat', $data);
    }

    public function BlackListMahasiswa()
    {
        PagePerm(['Dosen'], 'error_perm', false, 1);

        $dataPost = $this->request->getPost('id');

        $data['id'] = $dataPost;

        $model = model('AuthUserGroup');

        $data['namaMHS'] = $model->cekmahasiswainfo($data['id'])['NamaUser'];

        return view('suratkeluar/pengajaran/BLMHSW', $data);
    }

    public function BlackListMahasiswaProses()
    {
        PagePerm(['Dosen'], 'error_perm', false, 1);

        $dataPost = $this->request->getPost(['id', 'diskripsi']);

        $model = model('ServerConfig');

        if (!$model->addBL($dataPost['id'], $dataPost['diskripsi'])) {
            return FlashMassage('Staff/Permintaan_TTD-Surat_Tanpa_NoSurat', [resMas('F')], 'fail');
        }

        return FlashMassage('Staff/Permintaan_TTD-Surat_Tanpa_NoSurat', [resMas('S')], 'success');
    }

    // !END untuk pengajaran



    // !START untuk PenandaTangan
    public function indexStatusTTD()
    {
        PagePerm(['Dosen']);

        $dataGet = ($filter = $this->request->getGet('filter')) ? $filter : 'all';
        $dataGetTextF = ($filter = $this->request->getGet('TextF')) ? $filter : null;
        $limitQuary = ($filter = $this->request->getGet('limit')) ? $filter : 10;


        $dateStart = ($filter = $this->request->getGet('tglS')) ? $filter : null;
        $dateEnd = ($filter = $this->request->getGet('tglE')) ? $filter : null;

        $data['dateStart'] = $dateStart;
        $data['dateEnd'] = $dateEnd;



        $data['filter'] = $dataGet;
        $data['dataGetTextF'] = $dataGetTextF;
        $data['limit'] = $limitQuary < 0 ? 1 : $limitQuary;
        $data['jenisFilter'] = $this->Filter_Jenis_Surat;

        $model = model('TandaTangan');
        $data['datasurat'] = $model->cekStatusSuratTTD(
            userInfo(),
            0,
            $dataGet,
            $dataGetTextF,
            $dateStart,
            $dateEnd,
            $data['limit']
        );
        $data['perluttd'] = count($data['datasurat']);

        return view('suratkeluar/penandatangan/Semua_Perlu_TTD', $data);
    }

    public function TTDProses()
    {
        PagePerm(['Dosen'], 'error_perm', false, 1);

        $postdata = $this->request->getPost([
            'id',
        ]);

        $model = model('TandaTangan');
        $data['TTD'] = $model->cekStatusById($postdata['id']);


        if (!$data['TTD']['Status'] == 0) {
            return FlashMassage('/Surat_Perlu_TandaTangan', [resMas('f.u.save.ttd.k.ttd.done.exist')], 'fail');
        }

        $enkripsi = new enkripsi_library;

        $data['update']['Status']      = 1;
        $data['update']['qrcodeName']  =  "QRCode-" . generateIdentifier(16, 'time');
        $data['update']['hash']        = $enkripsi->get_EnkripsiTTD($data['TTD']['NoSurat'], $data['TTD']['mshw_id']);
        $data['update']['TimeStamp']   = getUnixTimeStamp();
        $data['update']['pendattg_id'] = userInfo()['id'];


        if (!Render_Qr($data['update']['hash'], $data['update']['qrcodeName'], userInfo()['id'])) {
            return FlashMassage('/Surat_Perlu_TandaTangan', [resMas('f.u.make.qr')], 'fail');
        }
        if (!$model->updateTTD($postdata['id'], $data['update'])) {
            return FlashMassage('/Surat_Perlu_TandaTangan', [resMas('f.u.save.ttd')], 'fail');
        }

        return FlashMassage('/Surat_Perlu_TandaTangan', [resMas('s.save.ttd')], 'success');
    }

    public function indexRiwayatTTD()
    {
        PagePerm(['Dosen']);


        $dataGet = ($filter = $this->request->getGet('filter')) ? $filter : 'all';
        $dataGetTextF = ($filter = $this->request->getGet('TextF')) ? $filter : null;
        $limitQuary = ($filter = $this->request->getGet('limit')) ? $filter : 10;


        $dateStart = ($filter = $this->request->getGet('tglS')) ? $filter : null;
        $dateEnd = ($filter = $this->request->getGet('tglE')) ? $filter : null;

        $data['dateStart'] = $dateStart;
        $data['dateEnd'] = $dateEnd;

        $data['filter'] = $dataGet;
        $data['limit'] = $limitQuary < 0 ? 1 : $limitQuary;
        $data['dataGetTextF'] = $dataGetTextF;
        $data['jenisFilter'] = $this->Filter_Jenis_Surat;

        $model = model('TandaTangan');
        $data['datasurat'] = $model->cekStatusSuratTTD(
            userInfo(),
            1,
            $dataGet,
            $dataGetTextF,
            $dateStart,
            $dateEnd,
            $data['limit']
        );

        return view('suratkeluar/penandatangan/Semua_Riwayat_TTD', $data);
    }

    public function reportSurat()
    {
        PagePerm(['Dosen'], 'error_perm', false, 1);

        $data['id'] = $this->request->getPost('id');

        return view('suratkeluar/penandatangan/Report_Surat', $data);
    }

    public function reportSuratProses()
    {
        PagePerm(['Dosen'], 'error_perm', false, 1);

        $postdata = $this->request->getPost(['id', 'diskripsi']);

        $diskirpsi['Pereport'] = userInfo()['id'] . "_" . userInfo()['NamaUser'] . ' ' . userInfo()['Gelar'];
        $diskirpsi['isi'] = $postdata['diskripsi'];

        $model = model('SuratKeluraModel');
        $id = $model->cekIdSuratByIdenti($postdata['id']);
        if (!$model->addReport($id, $diskirpsi)) {
            return FlashMassage('Surat_Perlu_TandaTangan', [resMas('f.u.save.report')], 'fail');
        }
        return FlashMassage('Surat_Perlu_TandaTangan', [resMas('s.save.report')], 'success');
    }
    // !END untuk PenandaTangan

    // !START untuk semua pengguna
    public function kameraQR()
    {
        $data['nocam'] = false;
        $nocam = $this->request->getGet('nocam');

        if ($nocam !== null) {
            if ($nocam == "true") {
                $data['nocam'] = true;
            }
        }
        return view("suratkeluar/kameraqr", $data);
        // return view("html5qrscanner", $data);
    }
    // !END untuk semua pengguna
}
