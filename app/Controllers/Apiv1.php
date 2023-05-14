<?php

namespace App\Controllers;

use App\Controllers\BaseController;
use App\Libraries\validasienkripsi;
use CodeIgniter\API\ResponseTrait;
use CodeIgniter\RESTful\ResourceController;

//http://localhost:8080/api/v1/validasi/qr?nosurat=123&qrcode=DiTandaTanganiOleh_nama_pQghxNEWWn4D0%2B7tpnnP2fB7wOuk57vPU9R2dzeHp%2BwHHqJrRgvTkSrZ53ukx7doQP7kSL2oHeN17NBJoD13S79DfAyDd078dXNXULMzxh2TNi9njW6Ftd6MgnoG5MU9

// class Apiv1 extends BaseController
class Apiv1 extends ResourceController
{
    use ResponseTrait;
    public function validasiqr()
    {
        $validasienkripsi = new validasienkripsi();
        if (isset($_GET["nosurat"]) && isset($_GET["qrcode"])) {
            $nosurat = $_GET["nosurat"];
            $datahash = $_GET["qrcode"];
            $validasienkripsi = new validasienkripsi();
            $data = $validasienkripsi->validasiEnkrispsi($datahash, $nosurat);
            $datahash = $validasienkripsi->validasiTTD($data[2], $nosurat);
            $datajson['valid'] = $datahash[5];
            return $this->respond($datajson);
        }
    }

    public function validasiqrdetail()
    {
        $validasienkripsi = new validasienkripsi();
        if (isset($_GET["nosurat"]) && isset($_GET["qrcode"])) {
            $nosurat = $_GET["nosurat"];
            $datahash = $_GET["qrcode"];
            $validasienkripsi = new validasienkripsi();
            $data = $validasienkripsi->validasiEnkrispsi($datahash, $nosurat);
            $datahash = $validasienkripsi->validasiTTD($data[2], $nosurat);

            if ($datahash[5] == "HashNotValid") {
                $datajson['valid'] = $datahash[5];
                return $this->respond($datajson);
            }
            $datajson['valid'] = $datahash[5];
            $datajson['nosurat'] = $datahash[0];
            $datajson['UUID'] = $datahash[1];
            $datajson['Penandatangan'] = $datahash[2];
            $datajson['Mahasiswa'] = $datahash[3];
            $datajson['timestamp'] = $datahash[4];
            return $this->respond($datajson);
        }
    }
}
