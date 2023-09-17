<?php

namespace App\Controllers;

use App\Libraries\enkripsi_library;
use CodeIgniter\API\ResponseTrait;
use CodeIgniter\RESTful\ResourceController;


class Apiv1 extends ResourceController
{
    use ResponseTrait;
    public function validasiqr()
    {
        $dataGet = $this->request->getGet([
            'nosurat',
            'qrcode'
        ]);

        if ($dataGet['nosurat'] !== null && $dataGet['qrcode'] !== null) {

            helper('datacall');

            $validasienkripsi = new enkripsi_library;
            $data['dataJson'] = $validasienkripsi->validasiTTD($dataGet['qrcode'], $dataGet['nosurat']);

            $data['respond'] = [
                'valid' => $data['dataJson']['valid']
            ];

            return $this->respond($data['respond']);
        }

        helper('datacall');

        $data['respond'] = [
            'valid' => resMas('e.param.n.exist')
        ];
        return $this->respond($data['respond']);
    }

    public function validasiqrdetail()
    {
        $dataGet = $this->request->getGet([
            'nosurat',
            'qrcode'
        ]);

        if ($dataGet['nosurat'] !== null && $dataGet['qrcode'] !== null) {

            helper(['textsurat', 'datacall']);

            $validasienkripsi = new enkripsi_library;

            $data['dataJson'] = $validasienkripsi->validasiTTD($dataGet['qrcode'], $dataGet['nosurat']);

            if ($data['dataJson']['pendattg_id'] == resMas('e')) {

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

            // return d($data);
            $model = model('AuthUserGroup');

            $penandatangan = $model->cekdoseninfo($data['dataJson']['pendattg_id']);
            $Mahasiswa = $model->cekmahasiswainfo($data['dataJson']['mshw_id']);

            $data['respond']['nosurat']       = $data['dataJson']['NoSurat'];
            $data['respond']['JenisSurat']    = $data['dataJson']['jenisSurat'];
            $data['respond']['Mahasiswa']     = $Mahasiswa['NamaUser'];
            $data['respond']['penandatangan'] = $penandatangan['NamaUser'] . ' ' . $penandatangan['Gelar'];
            $data['respond']['TimeStamp']     = timeconverter($data['dataJson']['TimeStamp']);
            // $data['respond']['TimeStamp']     = 30;
            $data['respond']['valid']         = $data['dataJson']['valid'];

            // d($data);
            // d($Mahasiswa);
            // d($penandatangan);
            // return;
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

    function cekNoSurat()
    {
        $dataGet = $this->request->getGet(['nosurat', 'token']);
        helper('datacall');

        $data = [
            'status'  => '2',
            'massage' => resMas('e')
        ];

        if (is_null($dataGet['nosurat']) || is_null($dataGet['token'])) {

            $data = [
                'status'  => '2',
                'massage' => 'API PARAM ERROR'
            ];
            return $this->respond($data);
        }

        $model2 = model('TempPin');

        if (!$model2->cekPinAPI($dataGet['token'])) {
            return $this->respond($data);
        }

        $model = model('SuratKeluraModel');
        $dataSurat['respond'] = $model->cekExistNoSurat(base64_decode($dataGet['nosurat']));
        return $this->respond($dataSurat['respond']);
    }

    public function imagecache($imagename)
    {
        $image = \Config\Services::image();
        // return 'asset/logo/unmuh.png';
        $path = '';
        $data['imagepath'] = match ($imagename) {
            'logo'  => 'asset/logo/unmuh.png',
            default => 'asset/logo/error_img.png',
        };

        $binary = readfile($data['imagepath']);
        $options = [
            'max-age'  => 2592000,
            's-maxage' => 2592000,
            'etag'     => 'abcde',
        ];

        return $this->response

            ->setHeader('Content-Type', 'image/png')
            ->setCache($options)
            // ->setHeader('Content-Type', $file->getMimeType())
            // ->setHeader('Content-disposition', 'inline; filename="' . $file->getBasename() . '"')
            ->setStatusCode(200)
            ->setBody($binary);
        // return $data['imagepath'];
    }
}
