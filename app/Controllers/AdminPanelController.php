<?php

namespace App\Controllers;

use App\Controllers\BaseController;
use App\Models\JenisSuratMasukModel;
use App\Models\MasterSuratModel;
use App\Models\SuratKeluraModel;
use App\Models\SuratMasukModel;
use App\Models\TandaTangan;

class AdminPanelController extends BaseController
{
    public function index()
    {
        PagePerm(['Dosen', 'Administrator'], 'login', false, 1);

        // $model = model('AdminPanel');
        // d($model->cekAdmin(userInfo()['id']));

        // d(userInfo());

        // d(userAdmin());
        // d($this->request->is('post'));
        // d(userInfo());
        if (!in_admin()) {
            return view('adminpanel/notAdmin');
        }

        if (!userAdmin()) {
            return view('adminpanel/loginAdmin');
        }

        return view('adminpanel/indexpanel');
    }

    public function addinformations()
    {
        PagePerm(['Dosen', 'Administrator'], 'login', false, 1);

        $model = model("ServerConfig");
        $data['informations'] = $model->getServerConfig('informations');

        return view('adminpanel/addinformations', $data);
    }

    public function addinformationsProses()
    {
        PagePerm(['Dosen', 'Administrator'], 'login', false, 1);

        $getPost = $this->request->getPost('inputisi');
        $model = model("ServerConfig");
        delCacheData('InformationsBoards', '');

        if (!$model->addServerConfig('informations', $getPost)) {
            return FlashMassage('/Admin-Panel/Input-info/upload', [resMas('f.save')], 'fail');
        }
        return FlashMassage('/', [resMas('s.save')], 'success');
    }

    public function createNewuser()
    {
        if (!userAdmin()) {
            throw new \CodeIgniter\Router\Exceptions\RedirectException("/Admin-Panel");
        }

        $pin1 = hash('sha256', generateIdentifier());
        $data['pin1'] = $pin1;
        $data['pin2'] = '';
        $model = model('TempPin');

        if ($this->request->is('get')) {
            $model->buatPin($pin1);
        }

        if ($this->request->is('post')) {
            $getPost = $this->request->getPost('pin');
            $datapin = $model->refreshPin($getPost);
            $data['pin1'] = $datapin['pin1'];
            $data['pin2'] = $datapin['pin2'];
        }
        return view('adminpanel/createNewAdmin', $data);
    }


    public function newUser()
    {
        PagePerm(['Dosen', 'Administrator']);
        $model = model('TempPin');

        if ($this->request->is('get')) {
            $getGet = $this->request->getGet('pin');

            // d($getGet);
            if (!$model->confirmPin($getGet)) {
                // return;
                return redirect()->to('login');
            }

            $data['pin1'] = $getGet;
            return view('adminpanel/NewAdmin', $data);
        }

        if ($this->request->is('post')) {
            $getPost = $this->request->getPost(['pin1', 'pin2', 'password']);

            if (!$model->confirmPin2($getPost['pin1'], $getPost['pin2'])) {
                return redirect()->to('login');
            }

            $datapin = $model->refreshPin($getPost['pin1']);

            $model2 = model('AdminPanel');
            if (!$model2->newAdminProses($getPost['password'], $datapin['id_akun_pembuat'])) {
                return redirect()->to('/login');
            }

            return redirect()->to('/Admin-Panel');
        }
    }

    public function loginAdminProses()
    {
        PagePerm(['Dosen', 'Administrator'], 'login', false, 1);
        $getPost = $this->request->getPost('pass');
        $model = model('AdminPanel');
        $hasil = $model->adminProsesLogin(userInfo()['id'], $getPost);

        // d($hasil);
        // return;
        if (!$hasil) {
            throw new \CodeIgniter\Router\Exceptions\RedirectException("login");
        }

        $data = [
            'admin'    => $hasil
        ];

        $session = \Config\Services::session();
        $session->set($data);

        return redirect()->to('Admin-Panel');
    }

    public function uploadKopSuratKeServer()
    {
        PagePerm(['Dosen', 'Administrator']);

        return view('adminpanel/uploadKopSurat');
    }

    public function uploadKopSuratKeServerProses()
    {
        PagePerm(['Dosen', 'Administrator'], 'login', false, 1);

        $getPost = $this->request->getPost('SiapaYangMembuat');
        $getFile = $this->request->getFile('FileKop');

        $OriFilename = $getFile->getName();
        $OriFilename = str_replace(".php", '', $OriFilename);

        $tempfilename = generateIdentifier(16) . ' by- ' . $getPost . ".php";
        $filePath = WRITEPATH . '/temp/KopSurat/';


        // Cek extension file
        $extension = $getFile->getExtension();
        if ($extension != 'html') {
            return FlashException('Jenis File Salah');
        }

        // Pindahkan file dari tmp ke folder temp server
        if (!$getFile->move($filePath, $tempfilename)) {
            return FlashException('error tidak dapat memindahkan file');
        }

        // Deteksi Apakah ada Script pada file
        if (DeteksiScript($filePath, $tempfilename)) {
            // echo "gagal memindai";
            return;
        }

        // bila sudah aman maka pindahkan ke production folder
        if (!moveFile($filePath . $tempfilename, APPPATH . 'Views/surat/kopSurat/' . $OriFilename . ' by- ' . $getPost . ".php")) {
            return FlashException('Gagal memindahkan File Ke Kop Surat');
        }

        return FlashMassage('/Admin-Panel/Upload-KopSurat', ['Berhasil Meng Upload Kop Surat'], 'success');
    }


    public function DB_Delete()
    {
        PagePerm(['Dosen', 'Administrator']);

        $modelSuratKeluraModel = model(SuratKeluraModel::class);
        $modelTandaTangan = model(TandaTangan::class);
        $modelMasterSuratModel = model(MasterSuratModel::class);
        $modelSuratMasukModel = model(SuratMasukModel::class);
        $modelJenisSuratMasukModel = model(JenisSuratMasukModel::class);


        $data['SK_ttd_MintaSurat'] = $modelSuratKeluraModel->SeeDel();
        $data['SK_ttd'] = $modelTandaTangan->SeeDel();
        $data['SK_MasterSurat'] = $modelMasterSuratModel->SeeDel();
        $data['SM_SuratArchice'] = $modelSuratMasukModel->SeeDel();
        $data['SM_JenisSuratArchice'] = $modelJenisSuratMasukModel->SeeDel();


        d($data);

        return view('adminpanel/DB_delete/indexdelete', $data);
    }

    public function DB_DeleteProses()
    {
        PagePerm(['Dosen', 'Administrator']);

        $getPost = $this->request->getPost('Table');
    }
}


// 0001096501

// f2d2f93738b3b44565e57aaaadc9fef9ba47484c4c6221917ec99f0db539de45

// dcf3cd25cbca070c8660286a0d2107659401f45689d799e4c40585dc98655fb8
