<?php

namespace App\Controllers;

use App\Controllers\BaseController;

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
        return view('adminpanel/indexpanel');
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

            if (!$model->confirmPin($getGet)) {
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
}
