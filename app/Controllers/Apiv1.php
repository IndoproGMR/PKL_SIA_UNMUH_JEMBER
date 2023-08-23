<?php

namespace App\Controllers;

use App\Libraries\enkripsi_library;
use App\Models\AuthUserGroup;
use CodeIgniter\API\ResponseTrait;
use CodeIgniter\RESTful\ResourceController;


// http://localhost:8080/api/v1/validasi/qr?nosurat=8Ne8V2aU&qrcode=DiTandaTanganiOleh_MUHAMMAD%20NAELY%20AZHAD_eitSNE9JTzg3K2MxYkFVemc4OExINGdqeW5hQ0VxZ29UOHZOQkxNcVl6YmJzUFB4dkZJdHVWODNLbnpSdkpoWkRMWmN6dmdFYy9FYTdzditqcVpMclE9PQ%3D%3D

class Apiv1 extends ResourceController
{
    use ResponseTrait;
    public function validasiqr()
    {
        // test data
        // $data['nosurat'] = '8Ne8V2aU';
        // $data['hashraw'] = 'DiTandaTanganiOleh_MUHAMMAD NAELY AZHAD_eitSNE9JTzg3K2MxYkFVemc4OExINGdqeW5hQ0VxZ29UOHZOQkxNcVl6YmJzUFB4dkZJdHVWODNLbnpSdkpoWkRMWmN6dmdFYy9FYTdzditqcVpMclE9PQ==';

        if (isset($_GET["nosurat"]) && isset($_GET["qrcode"])) {
            helper('datacall');

            $data['nosurat']  = $_GET["nosurat"];
            $data['hashraw']  = $_GET["qrcode"];
            $validasienkripsi = new enkripsi_library;
            $data['dataJson'] = $validasienkripsi->validasiTTD($data['hashraw'], $data['nosurat']);

            $data['respond'] = [
                'valid' => resMas($data['dataJson']['valid'])
            ];
            return $this->respond($data['respond']);
        }

        $data['respond'] = [
            'valid' => resMas('e.param.n.exist')
        ];
        return $this->respond($data['respond']);
    }

    // http://localhost:8080/api/v1/validasi/qr/detail?nosurat=8Ne8V2aU&qrcode=DiTandaTanganiOleh_MUHAMMAD%20NAELY%20AZHAD_eitSNE9JTzg3K2MxYkFVemc4OExINGdqeW5hQ0VxZ29UOHZOQkxNcVl6YmJzUFB4dkZJdHVWODNLbnpSdkpoWkRMWmN6dmdFYy9FYTdzditqcVpMclE9PQ%3D%3D

    public function validasiqrdetail()
    {
        // Test data
        // $data['nosurat'] = '8Ne8V2aU';
        // $data['hashraw'] = 'DiTandaTanganiOleh_MUHAMMAD NAELY AZHAD_eitSNE9JTzg3K2MxYkFVemc4OExINGdqeW5hQ0VxZ29UOHZOQkxNcVl6YmJzUFB4dkZJdHVWODNLbnpSdkpoWkRMWmN6dmdFYy9FYTdzditqcVpMclE9PQ==';

        if (isset($_GET["nosurat"]) && isset($_GET["qrcode"])) {
            helper('textsurat');

            $data['nosurat'] = $_GET["nosurat"];
            $data['hashraw'] = $_GET["qrcode"];

            $model = model(AuthUserGroup::class);
            $validasienkripsi = new enkripsi_library;

            $data['dataJson'] = $validasienkripsi->validasiTTD($data['hashraw'], $data['nosurat']);

            $data['respond']['nosurat']       = $data['dataJson']['NoSurat'];
            $data['respond']['JenisSurat']    = $data['dataJson']['jenisSurat'];
            $data['respond']['Mahasiswa']     = $model->cekuserinfo($data['dataJson']['mshw_id'])['NamaUser'];
            $data['respond']['penandatangan'] = $model->cekuserinfo($data['dataJson']['pendattg_id'])['NamaUser'];
            $data['respond']['TimeStamp']     = timeconverter($data['dataJson']['TimeStamp'])['date'];

            return $this->respond($data['respond']);
        }
        helper('datacall');

        $data['respond'] = [
            'nosurat'       => resMas('e'),
            'JenisSurat'    => resMas('e'),
            'Mahasiswa'     => resMas('e'),
            'penandatangan' => resMas('e'),
            'TimeStamp'     => resMas('e'),
            'valid'         => resMas('e.param.n.exist'),
        ];
        return $this->respond($data['respond']);
    }
}
